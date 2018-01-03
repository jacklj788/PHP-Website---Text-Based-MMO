<div id="mainSectionHome">

<div id="paymentBenefitDetails">
	<h2>Become VIP Today</h2>
	<p>For <strong>£4.99</strong> you can become a VIP member, granting you the following benefits</p>
	<ul>
	<li>A Golden Crown icon next to your name for all to see.</li>
	<li><strong>Energy Cap raise: </strong> double your maximum energy from 100 to 200!</li>
	<li>Heal for free!</li>
	<li>5000 in game gold</li>
	<ul>
<div>

<div id="paypal-button"></div>

</div>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<script>
			paypal.Button.render({

            env: 'sandbox', // Or 'sandbox',

            client: {
                // Key codes generated on my dev account. 
                sandbox: 'AWyh4EH-vgQhTSV_5qjqHc0Fa_nCiqoCKJSK-zvUdmYF5gj5HL6Sv93Y8Rjw-7YByyhQpnMrjUYNALBY',
                production: 'AbUBCNM6ykMe48X0ZUhm6PjjDz8fvX8sWTlEnPPQ45ZCQTu0armNO5wElEbLTaulIN_PjrcKuLmRs5gE'
            },

            commit: true, // Show a 'Pay Now' button

            style: {
                size: 'medium',
                color: 'gold',
                shape: 'rect',
                label: 'checkout'
            },


            payment: function(data, actions) {
                // Set up the payment here
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: { total: 4.99, currency: 'GBP' }
                            }
                        ]
                    }
                });
            },


            onAuthorize: function(data, actions) {
                    // Execute the payment here
                return actions.payment.execute().then(function (payment) {

                        // Lets the user know it all worked
                        window.alert("Payment Complete");
                        // Redirect to another page
                        window.location.replace("http://mi-linux.wlv.ac.uk/~1610476/index.php/welcome/confirmPayment");

                        // The payment is complete!
                        // You can now show a confirmation message to the customer
                    });
           }

        }, '#paypal-button');
</script>