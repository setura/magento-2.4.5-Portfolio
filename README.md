# magento-2.4.5-Portfolio

This project has some modules that I created myself to improve my knowledge in Magento 2


##### Amaro_Customer 
   * Created and EAV attribute for the customer, added frontendt and backend validation for the new attribute and added the possiblity to filter this attribute on admin grid

##### Amaro_Blog 
   * Created an entity with extension attributes and Admin CRUD features 

##### Amaro_SimpleForm 
   * Composite design pattern example

##### Amaro_Example 
   * Using user sensitive information to show cacheble pages variations with htppContext https://devdocs.magento.com/guides/v2.2/extension-dev-guide/cache/page-caching/public-content.html

##### Amaro_Notifications 
   * Showing private information from the user on cachble pages using sections
   * Created WebAPIs for admin and regular user to access the Amaro_Notifications

##### Amaro_PriceBook 
   * Creates the table of the pricebook 
##### Amaro_PriceBookCatalog 
   * Creates the extension attribute and adds it to the Catalog entity
##### Amaro_PriceBookCustomer
   * Creates the customer pricebook attribute and updates the HTTP context with it
##### Amaro_PriceBookElasticsearch
   * Adds the pricebook as a filter in ES and filter it according to the HTTP context

##### Amaro_DeliveryDate
   * Creates extension attribute 'delivery_date' for quote and order and adds custom column to quote,sales_order and sales_order_grid tables
##### Amaro_DeliveryDateAdminUi 
   * Adds the delivery date to the sales order grid and order view in admin. Also copys the delivery date from sales_order to sales_order_grid
##### Amaro_DeliveryDateCheckout 
   * Add checkout  delivery input calendar with all necessary configurations and respective API
##### Amaro_DeliveryDateEmail
   * Adds the delivery_date to the order confirmation email
##### Amaro_DeliveryDateFee
   * Creates a input in the admin for custom value input for the delivery fee and applies fee to quote
##### Amaro_DeliveryDateQuote
   * Extension attribute Repositoty for the quote
##### Amaro_DeliveryDateSales
   * Extension attribute Repositoty for the sales
