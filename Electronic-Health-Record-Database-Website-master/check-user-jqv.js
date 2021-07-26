$.validator.setDefaults({
	submitHandler: function() {
		//alert("submitted!");//for debugging purpose only
	}
});
 
$(document).ready(function() {

	jQuery.validator.addMethod("alphanumeric", function(value, element) {
	return this.optional(element) || /^[A-Za-z0-9]+$/.test(value);
	}, "Alphanumeric characters only");
	
	$("#form1").validate({
		rules: {			
			username: {
				required: true,
				alphanumeric: true,
				minlength: 4
			},
			password: {
				required: true,
				alphanumeric: true,
				minlength: 8
			}
		},
		messages: {			
			username: {
				required: "Please enter username",
				minlength: "At least 4 characters"
			},
			password: {
				required: "Please enter password",
				minlength: "At least 8 characters"
			}
		}
	});
});