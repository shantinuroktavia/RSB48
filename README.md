RSB48
==============================================
 Buku-Kuliah.com Instalasi
==============================================

##STEP 1 : Instalasi Project

Download folder RSB48 dan extract ke dalam directory htdocs.

##STEP 2 : Basis Data

**Prepare the FORM to redirect the customer**

```
<html>
<head>
	<title>Redirecting to Veritrans</title>
</head>
<body>	
	<form action= "<% out.print(veritrans.PAYMENT_REDIRECT_URL);%>" method="post" id='form'>
            <p> <% out.print(sid);%> </p>
            <input type="hidden" name="MERCHANT_ID" value= "<% out.print(veritrans.getMerchantId());%>" />
            <input type="hidden" name="ORDER_ID" value="<% out.print(veritrans.getOrderId());%>" />
            <input type="hidden" name="TOKEN_BROWSER" value="<% out.print(veritrans.getTokenBrowser());%>" />

            <input id="submitBtn" type="submit" value="Confirm Checkout" />
        </form>
        
        </script>
</body>
</html>
```


###STEP 3 : Responding Veritrans Payment Notification
After the payment is completed
Veritrans will contact Merchant's web server
As Merchant, you need to response this query
@TODO Validate request from veritrans, make sure it comes from veritrans not from hacker
 
**Create Veritrans Notification instance and set the attribute**

```
VeritransNotification vNotif = new VeritransNotification();
Map<String, String[]> responseMap = request.getParameterMap();
```

**Check if valid**

```
String tokenMerchant = "your_token_merchant";

String status;
if(vNotif.getTokenMerchant().equals(tokenMerchant)){
    status = "paid";
} else {
    status = "not paid";
}
```
