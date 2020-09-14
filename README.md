# Godaddy-Domains-API-in-PHP
Godaddy Domains API in PHP
Overview
The GoDaddy API allows developers to interact with the GoDaddy system in the same way we do. The API can be used by anyone who wants to manage their domains and account or create their own experience for registering, purchasing, and managing domains.

Setup
Note: If you are an API Reseller, you are already set up to go. Refer to the Reseller Control Center for help.

You will need to do the following before using the GoDaddy API:

Get Access

You will need an API Key and Secret to authenticate and authorize your requests.

The first API Key that you create will be a test key and should be used for your development against our OTE environment which is hosted at https://api.ote-godaddy.com. Integrate first with the OTE environment to verify that you are calling the API properly before going live with calls to the Production environment.

When you are ready for production, create a new API Key and Secret to call our production environment which is hosted at https://api.godaddy.com.

Set up Good as Gold

If you need to purchase any products such as a domain, you will need a Good as Gold account to complete transactions. The API will deduct the fixed rates of your purchase from this account so be sure to fund it accordingly.

Note: The GoDaddy API does not provide any payment processor or payment gateway. To collect money from your customers, you will need to set up your own payment processors.

Using the GoDaddy API
Users
There are two types of users of the API. It is important to understand the which category you fall under so you can use the API correctly.
Self-Serve: You are authenticated as and operating on your own account. You can ignore references to Subaccounts and theX-Shopper-Idheader.
Reseller: You authenticated as and operating on behalf of one of your customers. You will need to create a Subaccount to represent your end user and specify its ShopperId X-Shopper-Id in your API calls.
For any API that needs a customerId, you can get it here.

Calling the API
Here is a sample call using the API to check if a domain is available. Replace API_KEY and API_SECRETwith your API Key and Secret.

curl -X GET -H"Authorization: sso-key [API_KEY]:[API_SECRET]""https://api.godaddy.com/v1/domains/available?domain=example.guru"
Terms of use
Each API endpoint has an allotted number of calls you are allowed to make within a period of time (60 requests per minute). If you attempt to make more API calls to an endpoint than this allotted amount, the call will be rejected by the GoDaddy API and will return an HTTP status code of 429 and an error message indicating that your rate limit has been surpassed.

If you do receive an error indicating that you have exceeded your limit, the error message will tell you the duration you need to wait before resuming calls to that endpoint.

Documentation
Full reference documentation and ways to try out the API one call at a time.
https://developer.godaddy.com/doc
