$(document).ready(function(){
	
	// toggle carty
  var cartyVisible = localStorage.getItem('carty') == 'true'; // Get the value from localstorage
    $('#carty-container').toggle(cartyVisible); // Toggle sidebar, true: show, false: hide
    $('#carty-container').toggleClass('carty-show', cartyVisible); // Add class true: add, false: don't add

    $("a.toggleCarty").on('click', function () {
        $("#carty-container").toggle(function () {
            localStorage.setItem('carty', $('#carty-container').is(':visible')); // Save the visibility state in localstorage
        });

        $("#carty-container").toggleClass('carty-show');
    });
	
});