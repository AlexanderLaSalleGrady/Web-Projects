$.validator.setDefaults({
	submitHandler: function() {
		//alert("submitted!");//for debugging purpose only
	}
});
 
$(document).ready(function() {

	jQuery.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^[A-Za-z0-9]+$/.test(value);
	}, "Alphanumeric characters only");
	
	jQuery.validator.addMethod("valid_name", function(value, element) {
		return this.optional(element) || /^[a-z ,.-]+$/i.test(value);
	}, "Invalid name");
	
	$("#form2").validate({
		rules: {	
			first_name: {
				required: true,
				minlength: 2,
				valid_name: true
			},
			last_name: {
				required: true,
				minlength: 2,
				valid_name: true
			},			
			username: {
				required: true,
				alphanumeric: true,
				minlength: 4
			},
			password: {
				required: true,
				alphanumeric: true,
				minlength: 8
			},
			password2: {
				required: true,
				alphanumeric: true,
				minlength: 8,
				equalTo: "#password"
			}
		},
		messages: {	
			first_name: {
				required: "Please enter first name",
				minlength: "At least 2 characters"
			},
			last_name: {
				required: "Please enter last name",
				minlength: "At least 2 characters"
			},			
			username: {
				required: "Please enter username",
				minlength: "At least 4 characters"
			},
			password: {
				required: "Please enter password",
				minlength: "At least 8 characters"
			},
			password2: {
				required: "Please enter password",
				minlength: "At least 8 characters",
				equalTo: "Please enter the same password"
			}
		}
	});
});