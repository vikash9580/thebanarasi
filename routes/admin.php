<?php



/*

|--------------------------------------------------------------------------

| Admin Routes

|--------------------------------------------------------------------------

|

| Here is where you can register admin routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin','unbanned']);

Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin','unbanned']], function(){

	Route::resource('categories','CategoryController');



	Route::post('/store-token', 'WebNotificationController@storeToken')->name('store.token');

	Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');

	Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');

	Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');



	Route::resource('subcategories','SubCategoryController');

	Route::get('/subcategories/edit/{id}', 'SubCategoryController@edit')->name('subcategories.edit');

	Route::get('/subcategories/destroy/{id}', 'SubCategoryController@destroy')->name('subcategories.destroy');



	Route::resource('subsubcategories','SubSubCategoryController');

	Route::get('/subsubcategories/edit/{id}', 'SubSubCategoryController@edit')->name('subsubcategories.edit');

	Route::get('/subsubcategories/destroy/{id}', 'SubSubCategoryController@destroy')->name('subsubcategories.destroy');



	Route::resource('brands','BrandController');

	Route::get('/brands/edit/{id}', 'BrandController@edit')->name('brands.edit');

	Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');



	Route::get('/products/admin','ProductController@admin_products')->name('products.admin');

	Route::get('/products/seller','ProductController@seller_products')->name('products.seller');

	Route::get('/products/all','ProductController@all_products')->name('products.all');

	Route::get('/products/create','ProductController@create')->name('products.create');

	Route::get('/products/admin/{id}/edit','ProductController@admin_product_edit')->name('products.admin.edit');

	Route::get('/products/seller/{id}/edit','ProductController@seller_product_edit')->name('products.seller.edit');

	Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');

	Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');



	Route::resource('sellers','SellerController');

	Route::get('sellers_ban/{id}','SellerController@ban')->name('sellers.ban');

	Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');

	Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');

	Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');

	Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');

	Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');

	Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');

	Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');

	Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');



	Route::resource('customers','CustomerController');

   	    Route::get('wholesle_customers','CustomerController@wholesle_customers')->name('customers.wholesle');

		Route::post('wholesle_customers_validate/update', 'CustomerController@updateValidate')->name('wholesle_customers.validate');

		Route::get('normal_customers','CustomerController@normal_customers')->name('normal.customer');

	Route::get('customers_ban/{customer}','CustomerController@ban')->name('customers.ban');

		Route::get('staff_ban/{staff}','StaffController@ban')->name('staff.ban');

	Route::get('/customers/login/{id}', 'CustomerController@login')->name('customers.login');

	Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');



	Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');

	Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');



	Route::resource('profile','ProfileController');



	Route::post('/business-settings/update', 'BusinessSettingsController@update')->name('business_settings.update');

	Route::post('/business-settings/update/activation', 'BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');

	Route::get('/general-setting', 'BusinessSettingsController@general_setting')->name('general_setting.index');

	Route::get('/activation', 'BusinessSettingsController@activation')->name('activation.index');

	Route::get('/payment-method', 'BusinessSettingsController@payment_method')->name('payment_method.index');

	Route::get('/file_system', 'BusinessSettingsController@file_system')->name('file_system.index');

	Route::get('/social-login', 'BusinessSettingsController@social_login')->name('social_login.index');

	Route::get('/smtp-settings', 'BusinessSettingsController@smtp_settings')->name('smtp_settings.index');

	Route::get('/google-analytics', 'BusinessSettingsController@google_analytics')->name('google_analytics.index');

	Route::get('/google-recaptcha', 'BusinessSettingsController@google_recaptcha')->name('google_recaptcha.index');

	Route::get('/facebook-chat', 'BusinessSettingsController@facebook_chat')->name('facebook_chat.index');

	Route::post('/env_key_update', 'BusinessSettingsController@env_key_update')->name('env_key_update.update');

	Route::post('/payment_method_update', 'BusinessSettingsController@payment_method_update')->name('payment_method.update');

	Route::post('/google_analytics', 'BusinessSettingsController@google_analytics_update')->name('google_analytics.update');

	Route::post('/google_recaptcha', 'BusinessSettingsController@google_recaptcha_update')->name('google_recaptcha.update');

	Route::post('/facebook_chat', 'BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');

	Route::post('/facebook_pixel', 'BusinessSettingsController@facebook_pixel_update')->name('facebook_pixel.update');

	Route::get('/currency', 'CurrencyController@currency')->name('currency.index');

    Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');

    Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');

	Route::get('/currency/create', 'CurrencyController@create')->name('currency.create');

	Route::post('/currency/store', 'CurrencyController@store')->name('currency.store');

	Route::post('/currency/currency_edit', 'CurrencyController@edit')->name('currency.edit');

	Route::post('/currency/update_status', 'CurrencyController@update_status')->name('currency.update_status');

	Route::get('/verification/form', 'BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');

	Route::post('/verification/form', 'BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');

	Route::get('/vendor_commission', 'BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');

	Route::post('/vendor_commission_update', 'BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');



	Route::resource('/languages', 'LanguageController');

	Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');

	Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');

	Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');

	Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');



	Route::get('/frontend_settings/home', 'HomeController@home_settings')->name('home_settings.index');

	Route::post('/frontend_settings/home/top_10', 'HomeController@top_10_settings')->name('top_10_settings.store');

	Route::get('/sellerpolicy/{type}', 'PolicyController@index')->name('sellerpolicy.index');

	Route::get('/returnpolicy/{type}', 'PolicyController@index')->name('returnpolicy.index');

	Route::get('/supportpolicy/{type}', 'PolicyController@index')->name('supportpolicy.index');

	Route::get('/terms/{type}', 'PolicyController@index')->name('terms.index');

	Route::get('/privacypolicy/{type}', 'PolicyController@index')->name('privacypolicy.index');



	//Policy Controller

	Route::post('/policies/store', 'PolicyController@store')->name('policies.store');



	Route::group(['prefix' => 'frontend_settings'], function(){

		Route::resource('sliders','SliderController');

	    Route::get('/sliders/destroy/{id}', 'SliderController@destroy')->name('sliders.destroy');



		Route::resource('home_banners','BannerController');

		Route::get('/home_banners/create/{position}', 'BannerController@create')->name('home_banners.create');

		Route::post('/home_banners/update_status', 'BannerController@update_status')->name('home_banners.update_status');

	    Route::get('/home_banners/destroy/{id}', 'BannerController@destroy')->name('home_banners.destroy');



		Route::resource('home_categories','HomeCategoryController');

	    Route::get('/home_categories/destroy/{id}', 'HomeCategoryController@destroy')->name('home_categories.destroy');

		Route::post('/home_categories/update_status', 'HomeCategoryController@update_status')->name('home_categories.update_status');

		Route::post('/home_categories/get_subsubcategories_by_category', 'HomeCategoryController@getSubSubCategories')->name('home_categories.get_subsubcategories_by_category');

	});



	// website setting

	Route::group(['prefix' => 'website'], function(){

		Route::view('/header', 'backend.website_settings.header')->name('website.header');

		Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');

		Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');

		Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');

		Route::resource('custom-pages', 'PageController');

		Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');

		Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');

	});



	Route::resource('roles','RoleController');

	Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');

    Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');



    Route::resource('staffs','StaffController');

    Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');



	Route::resource('flash_deals','FlashDealController');

	Route::get('/flash_deals/edit/{id}', 'FlashDealController@edit')->name('flash_deals.edit');

  	Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');

	Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');

	Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');

	Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');

	Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');



	//Subscribers

	Route::get('/subscribers', 'SubscriberController@index')->name('subscribers.index');



	// Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');

	// Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');

	// Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');

	// Route::get('/sales', 'OrderController@sales')->name('sales.index');



	// All Orders

	Route::get('/all_orders', 'OrderController@all_orders')->name('all_orders.index');

	Route::get('/all_orders/{id}/show', 'OrderController@all_orders_show')->name('all_orders.show');

    Route::post('/wholesale_orders_store', 'OrderController@wholesale_order_store')->name('wholesale_orders');





	// Inhouse Orders

	Route::get('/inhouse-orders', 'OrderController@admin_orders')->name('inhouse_orders.index');

	Route::get('/inhouse-orders/{id}/show', 'OrderController@show')->name('inhouse_orders.show');



	// Seller Orders

	Route::get('/seller_orders', 'OrderController@seller_orders')->name('seller_orders.index');

	Route::get('/seller_orders/{id}/show', 'OrderController@seller_orders_show')->name('seller_orders.show');



	// Pickup point orders

	Route::get('orders_by_pickup_point','OrderController@pickup_point_order_index')->name('pick_up_point.order_index');

	Route::get('/orders_by_pickup_point/{id}/show', 'OrderController@pickup_point_order_sales_show')->name('pick_up_point.order_show');



	Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');

	Route::get('invoice/admin/{order_id}', 'InvoiceController@admin_invoice_download')->name('admin.invoice.download');



	Route::resource('links','LinkController');

	Route::get('/links/destroy/{id}', 'LinkController@destroy')->name('links.destroy');



	Route::resource('seosetting','SEOController');



	Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');



	//Reports

	Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');

	Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');

	Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');

	Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');

	Route::get('/user_search_report', 'ReportController@user_search_report')->name('user_search_report.index');

	Route::get('/agent_report', 'ReportController@agent_report')->name('agent_report.index');



	//Coupons

	Route::resource('coupon','CouponController');

	Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');

	Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');

	Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');



	//Reviews

	Route::get('/reviews', 'ReviewController@index')->name('reviews.index');

	Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');



	//Support_Ticket

	Route::get('support_ticket/','SupportTicketController@admin_index')->name('support_ticket.admin_index');

	Route::get('support_ticket/{id}/show','SupportTicketController@admin_show')->name('support_ticket.admin_show');

	Route::post('support_ticket/reply','SupportTicketController@admin_store')->name('support_ticket.admin_store');



	//Pickup_Points

	Route::resource('pick_up_points','PickupPointController');

	Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');

	Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');



	//conversation of seller customer

	Route::get('conversations','ConversationController@admin_index')->name('conversations.admin_index');

	Route::get('conversations/{id}/show','ConversationController@admin_show')->name('conversations.admin_show');



    Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');

    Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');



	Route::resource('attributes','AttributeController');

	Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');

	Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');



	Route::resource('addons','AddonController');

	Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');



	Route::get('/customer-bulk-upload/index', 'CustomerBulkUploadController@index')->name('customer_bulk_upload.index');

	Route::post('/bulk-user-upload', 'CustomerBulkUploadController@user_bulk_upload')->name('bulk_user_upload');

	Route::post('/bulk-customer-upload', 'CustomerBulkUploadController@customer_bulk_file')->name('bulk_customer_upload');

	Route::get('/user', 'CustomerBulkUploadController@pdf_download_user')->name('pdf.download_user');

	//Customer Package



	Route::resource('customer_packages','CustomerPackageController');

	Route::get('/customer_packages/edit/{id}', 'CustomerPackageController@edit')->name('customer_packages.edit');

	Route::get('/customer_packages/destroy/{id}', 'CustomerPackageController@destroy')->name('customer_packages.destroy');



	//Classified Products

	Route::get('/classified_products', 'CustomerProductController@customer_product_index')->name('classified_products');

	Route::post('/classified_products/published', 'CustomerProductController@updatePublished')->name('classified_products.published');



	//Shipping Configuration

	Route::get('/shipping_configuration', 'BusinessSettingsController@shipping_configuration')->name('shipping_configuration.index');

	Route::post('/shipping_configuration/update', 'BusinessSettingsController@shipping_configuration_update')->name('shipping_configuration.update');



	// Route::resource('pages', 'PageController');

	// Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');



	Route::resource('countries','CountryController');

	Route::post('/countries/status', 'CountryController@updateStatus')->name('countries.status');



	Route::resource('state','StateController');

	Route::get('whatsapp','HomeController@view_whatsapp')->name('whatsapp.view_whatsapp');

	Route::get('whatsapp/number_edit/{id}','HomeController@number_edit')->name('whatsapp.number_edit');

	Route::post('whatsapp/number_store','HomeController@number_store')->name('whatsapp.number_store');

	Route::post('whatsapp/number_update','HomeController@number_update')->name('whatsapp.number_update');

	Route::get('whatsapp/number_destroy/{id}','HomeController@number_destroy')->name('whatsapp.number_destroy');

	Route::post('/state/state_list', 'StateController@state_list')->name('state.state_list');



	Route::resource('city','CityController');

	Route::post('/city/city_list', 'CityController@city_list')->name('city.city_list');



	Route::resource('pincode','PincodeController');

	

	//CRM

	Route::resource('crm', 'CrmController');

	Route::get('/crm/destroy/{id}', 'CrmController@destroy')->name('crm.destroy');

	Route::get('/crm/quotation/{id}', 'CrmController@quotation')->name('crm.quotation');

	Route::post('/crm/generate_quotation', 'CrmController@generate_quotation')->name('crm.generate_quotation');

	Route::get('crmm/allquotation', 'CrmController@allquotation')->name('crm.allquotation');

	Route::get('crm/viewquotation/{quotation_number}', 'CrmController@viewquotation')->name('crm.viewquotation');

	Route::get('crm/viewduplicatequotation/{quotation_number}', 'CrmController@viewduplicatequotation')->name('crm.viewduplicatequotation');

	Route::post('crm/ordernow', 'CrmController@ordernow')->name('crm.ordernow');

	Route::post('/crm/variant', 'CrmController@variant')->name('crm.variant');

	Route::post('/crm/allproducts', 'CrmController@allproducts')->name('crm.allproducts');

	Route::get('crm/quotationbyseller/{reseller_id}', 'CrmController@quotationbyseller')->name('crm.quotationbyseller');

	Route::get('crm/user_info/{id}', 'CrmController@user_info')->name('crm.user_info');

	Route::get('crm/quotationdownload/{quotation_number}', 'CrmController@quotation_download')->name('crm.quotationdownload');

	Route::get('/crm/quotationduplicate/{id}', 'CrmController@quotationduplicate')->name('crm.quotationduplicate');

	Route::post('/crm/generate_duplicate_quotation', 'CrmController@generate_duplicate_quotation')->name('crm.generate_duplicate_quotation');

	Route::post('/crm/sellerinfo', 'CrmController@sellerinfo')->name('crm.sellerinfo');

	Route::get('/crmm/quotationwithuserview', 'CrmController@quotationwithuserview')->name('crm.quotationwithuserview');

	Route::post('/crm/quotationwithuser', 'CrmController@quotationwithuser')->name('crm.quotationwithuser');

	Route::post('/crm/newaddress', 'CrmController@newaddress')->name('crm.newaddress');

	



	Route::get('/crmm/all_orders', 'CrmController@all_orders')->name('crm.all_orders');

	Route::get('/crm/all_orders/{id}/show', 'CrmController@all_orders_show')->name('crm.show_orders');

  

  

  

    Route::get('/contact_followup_detail/{id}','CrmSellerController@getConatactFollowup')->name('contact_followup.detail');

    Route::post('/saveFollowupData','CrmSellerController@saveFollowupData')->name('saveFollowupData.save');

    Route::get('/send_notification','CrmSellerController@notification_template_index')->name('notification_template_index');

    Route::get('/crm_dashboard','CrmSellerController@dashboard')->name('crm.dashboard');

    Route::get('/crm_enquiry','CrmSellerController@enquiry')->name('crm.enquiry');
    
    Route::get('/crm_seller_quotation','CrmSellerController@crm_seller_quotation')->name('crm_seller.quotation');
    Route::get('/crm_seller_quotation_edit/{id}','CrmSellerController@crm_seller_quotation_edit')->name('crm_seller.quotation_edit');
    
    
    Route::get('/crm_seller_pi','CrmSellerController@crm_seller_pi')->name('crm_seller.pi');
    Route::get('/crm_seller_pi_edit/{id}','CrmSellerController@crm_seller_pi_edit')->name('crm_seller.pi_edit');
    

    Route::post('/contact_form_update/{id}','CrmSellerController@update')->name('crm.contact_form_update');

    Route::get('/crm_enquiry_form','CrmSellerController@create')->name('crm.enquiry_form');

    Route::post('/contact_form_save','CrmSellerController@store')->name('crm.contact_form_save');

    Route::get('notification_template','CrmSellerController@notification_template')->name('notification_template.details');

    Route::get('notification_info','CrmSellerController@notification_info')->name('notification_info.details');

    Route::post('notification_send','CrmSellerController@notification_send')->name('notification.send');

    Route::get('call_notification','CrmSellerController@call_notification')->name('call_notification');

    Route::get('crm_quotation','CrmSellerController@crm_quotation')->name('crm_quotation');

    Route::get('/crm_edit/{id}','CrmSellerController@edit')->name('contact_form.edit');

    Route::get('/send_message','CrmSellerController@message_template_index')->name('message_template_index');

    Route::post('/message_send','CrmSellerController@message_send')->name('message.send');

    Route::get('/crm_seller/allproducts', 'CrmSellerController@allproducts')->name('crm_seller.allproducts');

	Route::post('/crm_seller/quotationwithuser', 'CrmSellerController@quotationwithuser')->name('crm_seller.quotationwithuser');
	
	Route::post('/crm_seller/order_store', 'CrmSellerController@order_store')->name('crm_seller.order_store');
	Route::get('/crm_seller_orders','CrmSellerController@crm_seller_orders')->name('crm_seller.orders');
	Route::get('/crm_seller_order_detail/{id}','CrmSellerController@crm_seller_order_detail')->name('crm_seller.order_detail');

    Route::get('/generate_pi/{id}', 'CrmSellerController@generate_pi')->name('crm_seller.generate_pi');

    Route::get('message_templet','MessageController@message_template')->name('message.template');

    Route::get('flow_info','MessageController@flow_info')->name('flow_info.details');

    Route::get('all_flows','MessageController@all_flows')->name('all_flows.details');

    Route::post('message_template_create','MessageController@message_template_create')->name('message_template_create');

    Route::get('/message_templet_delete/{id}','MessageController@message_template_delete')->name('message.templet.delete');

	

	

	//Product Enquiry

	

	Route::get('enqiry_view', 'ContactFormController@enqiry_view')->name('enquiry.enqiry_view');

	

	//Contact Form

	Route::resource('contact', 'ContactFormController');

	Route::get('/contact/view/{id}', 'ContactFormController@view')->name('followups.view');

	

	 	Route::post('followup_call_save','ContactFormController@followup_call_save')->name('followup_call.save');

	 	Route::get('followup_call_ajax_pagination','ContactFormController@followup_call_ajax_pagination');

	 		Route::post('/followups/completed', 'ContactFormController@updateComplete')->name('followup.complete');

	

	

	Route::get('/crm/filter', 'ContactFormController@filter')->name('crm.filter');

	Route::post('/crm/ajxfilter', 'ContactFormController@ajxfilter')->name('crm.ajxfilter');

	Route::get('contact_delete/{id}', 'ContactFormController@followup_delete');



	Route::get('crmm/import', 'ContactFormController@importview')->name('crm.import');

	Route::get('crmm/export', 'ContactFormController@export')->name('crm.export');

	

	Route::get('/notification_check', 'HomeController@notification_check');

  

    Route::get('/productall', 'ProductController@productall');

  

	

	

});

