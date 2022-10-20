# magento-2.4.5-Portfolio

This project has some modules that I created myself to improve my knowledge in Magento 2


##### Monsoon_Customer 
   * Created and EAV attribute for the customer, added frontendt and backend validation for the new attribute and added the possiblity to filter this attribute on admin grid

##### Monsoon_Blog 
   * Created an entity with extension attributes and Admin CRUD features 

##### Monsoon_SimpleForm 
   * Composite design pattern example

##### Monsoon_Example 
   * Using user sensitive information to show cacheble pages variations with htppContext https://devdocs.magento.com/guides/v2.2/extension-dev-guide/cache/page-caching/public-content.html

##### Monsoon_Notifications 
   * Showing private information from the user on cachble pages using sections
   * Created WebAPIs for admin and regular user to access the Monsoon_Notifications

##### Monsoon_PriceBook 
   * Creates the table of the pricebook 
##### Monsoon_PriceBookCatalog 
   * Creates the extension attribute and adds it to the Catalog entity
##### Monsoon_PriceBookCustomer
   * Creates the customer pricebook attribute and updates the HTTP context with it
##### Monsoon_PriceBookElasticsearch
   * Adds the pricebook as a filter in ES and filter it according to the HTTP context

##### Monsoon_DeliveryDate
   * Creates extension attribute 'delivery_date' for quote and order and adds custom column to quote,sales_order and sales_order_grid tables
##### Monsoon_DeliveryDateAdminUi 
   * Adds the delivery date to the sales order grid and order view in admin. Also copys the delivery date from sales_order to sales_order_grid
##### Monsoon_DeliveryDateCheckout 
   * Add checkout  delivery input calendar with all necessary configurations and respective API
##### Monsoon_DeliveryDateEmail
   * Adds the delivery_date to the order confirmation email
##### Monsoon_DeliveryDateFee
   * Creates a input in the admin for custom value input for the delivery fee and applies fee to quote
##### Monsoon_DeliveryDateQuote
   * Extension attribute Repositoty for the quote
##### Monsoon_DeliveryDateSales
   * Extension attribute Repositoty for the sales
