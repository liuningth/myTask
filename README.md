1.folder [sql] include about sql
2.folder [front_code] include about front end code

* Build a simple signin where admin can login into the system. 
* Once admin login, they could:
* Create, update and delete a product. Product will contains Name, SKU, 
and an Image. 
* Create, update and delete a coupon. Coupon will have start date, end 
date and list of multiple product. 
* Everytime a coupon created, send an email notification to admin. 
Environment:
- Laravel 7 - CSS Bootstrap
- MySQL
- Blade file without Vue.js
Things to be noted:
- Secure system is no compromise, no SQL injection
- Never expose db integer id publicly into the URL like id=12345, you can use uuid 
or random string
- Make sure validation works properly and returning a proper error message
- Design the table structure as best as you could think
- Feel free to use any kind of ui template 
- Performance should be handle by care
- When you generate the product and coupon list page, try to use eager loading
