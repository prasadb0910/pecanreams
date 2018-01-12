$(document).ready(function() {
  
  var stack1 = $('#stack1');
  
  stack1.removeClass('start');
  
  stack1.hammer().on('tap', function(event) {
    stack1.addClass('hover');
    event.stopPropagation();
  });
  
  
  $(document).hammer().on('tap', function(event) {
    stack1.removeClass('hover');
    $('.card').removeClass('hover');
  });
  
  $('.card').hammer().on('tap', function(event) {
      $('.card').removeClass('hover');
      $(this).addClass('hover');
  });
});


var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = "none";
}