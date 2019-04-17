<?php

namespace App\Http\Controllers;

use App\User;
use App\Pn_notice_count;
use Illuminate\Http\Request;
use Session;
use DB;
use Carbon\Carbon;
use DateTime;

class Notice_countController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    
    function FormatDate($date, $format = 'd/m/Y') {
        $d = DateTime::createFromFormat($format, $date);
        $returnDate = null;
        if ($d && $d->format($format) == $date) {
            // $returnDate = DateTime::createFromFormat($format, $date)->format('Y-m-d');
            $dateInput = explode('/',$date);
            $returnDate = $dateInput[2].'-'.$dateInput[1].'-'.$dateInput[0];
        }

        return $returnDate;
    }

    public function get_data(Request $request) {
        $data = $request->all();

        $date_of_notice = $this->FormatDate($data['date_of_notice']);
        // $date_of_notice = '2018-08-29';

        $newspaper_count = 0;
        $total_notice_count = 0;
        $relevant_notice_count = 0;
        $non_relevant_notice_count = 0;
        $diff_notice_count = 0;
        $notice_count = 0;
        $i=1;

        $sql = "select E.*, (E.relevant_notice_count-E.no_of_notices) as diff_notice_count from 
                (select C.*, (C.notice_count-C.non_relevant_notice_count) as relevant_notice_count, ifnull(D.no_of_notices,0) as no_of_notices from 
                (select A.*, ifnull(B.notice_count,0) as notice_count, ifnull(B.non_relevant_notice_count,0) as non_relevant_notice_count from 
                (select * from pn_newspapers where status = 'approved') A 
                left join 
                (select * from pn_notice_counts where date(date_of_notice) = date('$date_of_notice')) B 
                on (A.id=B.fk_newspaper_id)) C 
                left join 
                (select fk_newspaper_id, count(id) as no_of_notices from pn_notices where status = 'approved' and 
                    date(date_of_notice) = date('$date_of_notice') group by fk_newspaper_id) D 
                on (C.id=D.fk_newspaper_id)) E 
                order by E.paper_name, E.updated_at desc";

        $newspapers = DB::select($sql);
        $rows = '';
        foreach($newspapers as $data){
            $rows = $rows . '<tr>
                                <td class="table-text">
                                    <div>'.$i++.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->paper_name.'</div>
                                </td>
                                <td class="table-text">
                                    <div>
                                        <input class="form-control" type="hidden" name="newspaper_id[]" value="'.$data->id.'" />
                                        <input class="form-control" type="text" name="total_notice_count[]" value="'.$data->notice_count.'" />
                                        <span style="display: none;">'.$data->notice_count.'</span>
                                    </div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->no_of_notices.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->relevant_notice_count.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->non_relevant_notice_count.'</div>
                                </td>
                                <td class="table-text">
                                    <div>'.$data->diff_notice_count.'</div>
                                </td>
                            </tr>';

            $newspaper_count = $newspaper_count + 1;
            $total_notice_count = $total_notice_count + intval($data->notice_count);
            $relevant_notice_count = $relevant_notice_count + intval($data->relevant_notice_count);
            $non_relevant_notice_count = $non_relevant_notice_count + intval($data->non_relevant_notice_count);
            $diff_notice_count = $diff_notice_count + intval($data->diff_notice_count);
            $notice_count = $notice_count + intval($data->no_of_notices);
        }

        $tfoot = '<tr>
                        <th class="table-text"></th>
                        <th class="table-text">
                            <div>Total Count</div>
                        </th>
                        <th class="table-text">
                            <div>'.$total_notice_count.'</div>
                        </th>
                        <th class="table-text">
                            <div>'.$notice_count.'</div>
                        </th>
                        <th class="table-text">
                            <div>'.$relevant_notice_count.'</div>
                        </th>
                        <th class="table-text">
                            <div>'.$non_relevant_notice_count.'</div>
                        </th>
                        <th class="table-text">
                            <div>'.$diff_notice_count.'</div>
                        </th>
                    </tr>';

        $result['rows'] = $rows;
        $result['tfoot'] = $tfoot;
        $result['newspaper_count'] = $newspaper_count;
        $result['total_notice_count'] = $total_notice_count;
        $result['relevant_notice_count'] = $relevant_notice_count;
        $result['non_relevant_notice_count'] = $non_relevant_notice_count;
        $result['diff_notice_count'] = $diff_notice_count;
        $result['notice_count'] = $notice_count;

        echo json_encode($result);
    }

    public function index() {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Notices'])) {
            if($access['Notices']['r_view']=='1' || $access['Notices']['r_insert']=='1' || $access['Notices']['r_edit']=='1' || $access['Notices']['r_delete']=='1' || $access['Notices']['r_approvals']=='1' || $access['Notices']['r_export']=='1') {
                // $date_of_notice = date('Y-m-d');

                // $sql = "select E.*, (E.relevant_notice_count-E.no_of_notices) as difference_count from 
                //         (select C.*, (C.notice_count-C.non_relevant_notice_count) as relevant_notice_count, D.no_of_notices from 
                //         (select A.*, ifnull(B.notice_count,0) as notice_count, ifnull(B.non_relevant_notice_count,0) as non_relevant_notice_count 
                //         from pn_newspapers A left join pn_notice_counts B on(A.id=B.fk_newspaper_id) 
                //         where A.status = 'approved' and date(B.date_of_notice) = date('$date_of_notice')) C 
                //         left join 
                //         (select fk_newspaper_id, count(id) as no_of_notices from pn_notices where status = 'approved' and 
                //                         date(date_of_notice) = date('$date_of_notice') group by fk_newspaper_id) D 
                //         on (C.fk_newspaper_id=D.fk_newspaper_id)) E 
                //         order by E.paper_name, E.updated_at desc";

                // $newspapers = DB::select($sql);

                return view('notice_count.index', ['access' => $access]);
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Count', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Count', 'msg' => 'You donot have access to this page.']);
        }
    }

    public function save(Request $request) {
        $user = new User();
        $access = $user->get_access();
        if(isset($access['Notices'])) {
            if($access['Notices']['r_insert']=='1' || $access['Notices']['r_edit']=='1' || $access['Notices']['r_delete']=='1' || $access['Notices']['r_approvals']=='1') {
                // $this->validate($request, [
                //     'paper_name' => 'required',
                //     'language' => 'required',
                //     'e_paper' => 'required',
                //     'frequency' => 'required',
                //     'area' => 'required',
                //     'price' => 'required',
                //     'news_type' => 'required',
                // ]);

                $date_of_notice = $this->FormatDate($request->get('date_of_notice'));
                $newspaper_id = $request->get('newspaper_id');
                $total_notice_count = $request->get('total_notice_count');
                $user_id = auth()->user()->gu_id;

                for($i=0; $i<count($newspaper_id); $i++){
                    if(intval($total_notice_count[$i])>0){
                        $affected = DB::update("update pn_notice_counts set notice_count = '".$total_notice_count[$i]."', 
                                            status = 'approved', updated_by = ".$user_id.", updated_at = now() 
                                            where date(date_of_notice) = date('".$date_of_notice."') and 
                                            fk_newspaper_id = '".$newspaper_id[$i]."'");
                    
                        if($affected==0){
                            $data['date_of_notice'] = $date_of_notice;
                            $data['fk_newspaper_id'] = $newspaper_id[$i];
                            $data['notice_count'] = $total_notice_count[$i];
                            $data['status'] = 'approved';
                            $data['created_by'] = $user_id;
                            $id = Pn_notice_count::create($data)->id;
                        }
                    }
                }

                Session::flash('success_msg', 'Notice count updated!');
                return redirect('index.php/notice_count');
            } else {
                return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Count', 'msg' => 'You donot have access to this page.']);
            }
        } else {
            return view('message', ['access' => $access, 'title'  => 'Access Denied', 'module' => 'Notice Count', 'msg' => 'You donot have access to this page.']);
        }
    }
}
