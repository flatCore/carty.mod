<div class="container-fluid">
<form action="{form_action}" method="POST">
	<div class="form-group">
		<label for="email_input">{label_mail}*</label>
		<input type="email" class="form-control" id="email_input" name="carty_sender_mail" value="{carty_sender_mail}">
	</div>
	<div class="row">
		<div class="form-group col-sm-6">
			<label for="firstname_input">{label_firstname}*</label>
			<input type="text" class="form-control" id="firstname_input" name="carty_sender_firstname" value="{carty_sender_firstname}">
		</div>
		<div class="form-group col-sm-6">
			<label for="name_input">{label_lastname}*</label>
			<input type="text" class="form-control" id="name_input" name="carty_sender_name" value="{carty_sender_name}">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-sm-9">
			<label for="street_input">{label_street}*</label>
			<input type="text" class="form-control" id="street_input" name="carty_sender_street" value="{carty_sender_street}">
		</div>
		<div class="form-group col-sm-3">
			<label for="street_nbr_input">{label_street_nbr}*</label>
			<input type="text" class="form-control" id="street_nbr_input" name="carty_sender_street_nbr" value="{carty_sender_street_nbr}">
		</div>
	</div>
	<div class="row">
		<div class="form-group col-sm-4">
			<label for="zip_input">{label_zip}*</label>
			<input type="text" class="form-control" id="zip_input" name="carty_sender_zip" value="{carty_sender_zip}">
		</div>
		<div class="form-group col-sm-8">
			<label for="city_input">{label_city}*</label>
			<input type="text" class="form-control" id="city_input" name="carty_sender_city" value="{carty_sender_city}">
		</div>
	</div>
	<div class="form-group">
		<label for="message_input">{label_message}</label>
		<textarea class="form-control" id="message_input" name="carty_sender_message">{carty_sender_message}</textarea>
	</div>
	<hr>
  <div class="form-group mt-2">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="privacy_check" name="privacy_check" value="agree">
      <label class="form-check-label" for="privacy_check">
        {message_privacy_check}
      </label>
    </div>
  </div>
  <p class="small">* {label_mandatory_input}</p>
	<button type="submit" name="send_carty_form" class="btn btn-success btn-block w-100">{btn_send_carty}</button>
	
	<input type="hidden" name="sender_products" value="{carty_form_hidden_product_str}">
</form>
</div>