## carty.mod - flatCore Addon

With carty.mod your customers can collect products in a list and send this list via form to you. __Please note__ this is not a production-ready E-Commerce Solution or an Online Shop. It's just of a simple shopping list with a contact form.

### Way that works

* Add Products to your Site with the Posts/Products Section
* Add the carty Button to your Theme
* user hits the __add to carty__ Button
* we store the Product
* user can send the list

#### add to carty Button

To get the __add to carty__ Button you have to use the following snippet in the template files ...

* post-list-p.tpl
* post-display-p.tpl

```
	<form action="{fct_slug}" method="POST" class="d-inline">
		<button class="btn btn-success">{btn_add_to_carty}</button>
		<input type="hidden" name="add_to_carty" value="{post_id}">
	</form>
```