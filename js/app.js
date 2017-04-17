$('document').ready(function()
{ 
     /* validation */
	 $("#login-form").validate({
      rules:
	  {
			password: {
			required: true,
			},
			user_email: {
            required: true,
            email: true
            },
	   },
       messages:
	   {
            password:{
                      required: "please enter your password"
                     },
            user_email: "please enter your email address",
       },
	   submitHandler: submitForm	
       });  
	   /* validation */
	   
	   /* login submit */
	   function submitForm()
	   {		
			var data = $("#login-form").serialize();
				
			$.ajax({
				
			type : 'POST',
			url  : 'login_process.php',
			data : data,
			beforeSend: function()
			{	
				$("#error").fadeOut();
				$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Validating ...');
			},
			success :  function(response)
			   {						
					if(response=="ok"){
									
						$("#btn-login").html('<img src="images/loading-ajax.svg" /> &nbsp; Signing In ...');
						setTimeout(' window.location.href = "camper-list.php"; ',3000);
					}
					else{
									
						$("#error").fadeIn(1000, function(){						
				$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
											$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
									});
					}
			  }
			});
				return false;
		}
	   /* login submit */
	   
	   $(".menu").click(function(){
        $(".navigation").slideToggle();
    });


	/* Camp Enter Date validation */
	 $("#add-camp-date-form").validate({
      rules:
	  {
			camp_reg_date: {
			required: true,
			},
		},
       messages:
	   {
            camp_reg_date:{
                      required: "please enter the date"
                     },            
       },
	   //submitHandler: submitForm	
       });  
	

	 /* DELETE CONFIRMATION 
	* =============================== */
	$('[data-toggle=confirmation]').confirmation({
		rootSelector: '[data-toggle=confirmation]',
  // other options
});
});

