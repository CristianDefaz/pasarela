

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AccNCRFV8ls9FEbBcYYtZy01NsnqoC_qr48WMwu_mVoW4NpYNkNtVzvUsvztHCK0pNpzMJ--5k_VNATq&currency=USD"></script>
</head>
<body>
    <div id="paypal-button-container"></div>
    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 150
                        }
                    }]
                });
            },
            onApprove: function(data, actions){
                actions.order.capture().then(function(detalles){
                    // Enviar detalles al servidor
                    guardarDetallesEnBD(detalles);
                });
            },
            onCancel: function(data){
                alert("Pago cancelado");
                console.log(data);
            }
        }).render('#paypal-button-container');

        function guardarDetallesEnBD(detalles) {
            // Enviar detalles al servidor mediante AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "guardar_detalles.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText);
                }
            };
            xhr.send(JSON.stringify(detalles));
        }
    </script>
</body>
</html>
