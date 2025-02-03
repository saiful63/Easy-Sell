
# About Easy Sell

Easy sell is a point on sell application. User satisfaction and performance is main aim of this software and it is acheived through developing it as single page application.It automates selling process from uploading product to genarate invoice.

# Technology Used

    1. Laravel
    2. Vue Js
    3. Inertia

# Features
   1.It is multiuser application , so multiple seller can sell their products to customer.

   2.Custom Registration and login : Designed and developed session based registration and login.

   3.Dashboard: It includes create customer,category,product,manage profile.Actually crud operation is performed to develop this features.

   4.Sell Product: Three table here,one for product showing ,one for customer showing and another for generating invoice.Vue js ref is used to acheive two way binding and computed for mathematical calculation.

5.Invoice: List of invoice is visible that is produced from Sell Product section.   It is possible to download particular invoice from this section.

# Best Practices
  1.Used DB transaction and rollback in dependent operation such as in invoices and invoice_product.

  2.Create Facade for file delete, so it can be used in entire project according to necessity.Understood service container and provider during development of this Facade.

  3.Wrote optimized query. Fetch data from column which is required, didn't use (*) all time in query.

# Scope
1.Api endpoint is created as other platforms can use it. JWT token is used for authentication when they deal with api.
   