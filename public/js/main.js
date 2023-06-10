$(document).ready(function () {
    filter('Main Dish');
});

function filter($category) {
    var img = "images/f1.png";
    if ($category == 'Side Dish') {
        img = "images/f2.png";
    } else if ($category == 'Dessert') {
        img = "images/f3.png";
    }

    var active = 'active';
    $.ajax({
        url: '/api/products',
        type: 'GET',
        data: {
            category: $category,
        },
        success: function (response) {
            $('#filters-menu-container').empty();
            active = ($category == 'Main Dish') ? 'active' : '';
            var button_1 = $('<li class="mx-2 ' + active + '">Main Dishes</li>');
            button_1.click(function () {
                filter('Main Dish');
            });

            active = ($category == 'Side Dish') ? 'active' : '';
            var button_2 = $('<li class="mx-2 ' + active + '">Side Dishes</li>');
            button_2.click(function () {
                filter('Side Dish');
            });

            active = ($category == 'Dessert') ? 'active' : '';
            var button_3 = $('<li class="mx-2 ' + active + '">Desserts</li>');
            button_3.click(function () {
                filter('Dessert');
            });
            $('#filters-menu-container').append(button_1, button_2, button_3);

            $('#card-container').empty();

            // Iterate over the data and create Bootstrap cards
            $.each(response, function (index, data) {

                // plus button
                var plus_btn = $('<button type="button"><i class="fas fa-plus"></i></button>');
                plus_btn.click(function () {
                    addOrder(data.id, data.name, data.category, data.price);
                });

                var card = $('<div class="col-sm-6 col-lg-4"></div>');
                var box = $('<div class="box"></div>');
                var img_div = $('<div class="img-box"> <img src=' + img + ' alt=""></div>');
                var detail_box = $('<div class="detail-box"></div>');
                var name = $('<h5>' + data.name + '</h5>');
                var description = $('<p>' + data.description + '</p>');
                var options = $('<div class="options"></div>');
                var price = $('<h6>Rs. ' + data.price + '</h6>');

                box.appendTo(card);
                img_div.appendTo(box);
                detail_box.appendTo(box);
                name.appendTo(detail_box);
                description.appendTo(detail_box);
                options.appendTo(detail_box);
                price.appendTo(options);
                plus_btn.appendTo(options);

                $('#card-container').append(card);
            });
        },
        error: function (xhr, status, error) {
            alert('error');
            console.error(error);
        }
    });
}

function addOrder($id, $name, $category, $price) {

    if (checkIdExists($id, $price)) {
    } else {
        var row = $('<tr>');
        row.append($('<td>').text($id));
        row.append($('<td>').text($name));
        row.append($('<td>').text('1'));
        row.append($('<td>').text($price));

        var detele_btn = $('<button type="button" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>');
        detele_btn.click(function () {
            $(this).closest('tr').remove();
            totalAmount();
        });
        row.append($('<td>').append(detele_btn));

        $('#order-table tbody').append(row);
    }
    totalAmount();
}

function checkIdExists(id, price) {
    var table = document.getElementById("order-table");
    var rows = table.getElementsByTagName("tr");
    for (var i = 1; i < rows.length; i++) { // Start from index 1 to skip header row
        var cell = rows[i].getElementsByTagName("td")[0]; // Assuming the ID is in the first column (index 0)
        var cell_quantity = rows[i].getElementsByTagName("td")[2]; // Assuming the ID is in the first column (index 0)
        var cell_price = rows[i].getElementsByTagName("td")[3]; // Assuming the ID is in the first column (index 0)
        if (cell.innerText == id) {
            cell_quantity.innerText = parseFloat(cell_quantity.innerText) + 1;
            cell_price.innerText = parseFloat(cell_price.innerText) + price;

            totalAmount();
            return true; // ID exists in the table
        }
    }
    return false; // ID does not exist in the table
}

function totalAmount() {
    var amount = 0;
    var table = document.getElementById("order-table");
    var rows = table.getElementsByTagName("tr");
    for (var i = 1; i < rows.length; i++) {
        var cell_price = rows[i].getElementsByTagName("td")[3];
        amount = parseFloat(cell_price.innerText) + amount;
    }

    $('#total-amount').html(amount);
}

$('#saveOrderForm').submit(function (event) {
    event.preventDefault();

    // var tableData = [
    //     { food_id: '1', quantity: 25 },
    //     { food_id: '2', quantity: 30 }
    // ];

    var tableData = [];
    var table = document.getElementById("order-table");
    var rows = table.getElementsByTagName("tr");
 
    if (rows.length <= 1) {
        alert('Please select foods');
    } else {
        for (var i = 1; i < rows.length; i++) {
            var cell_id = rows[i].getElementsByTagName("td")[0];
            var cell_quantity = rows[i].getElementsByTagName("td")[2];
            var cell_price = rows[i].getElementsByTagName("td")[3];

            var object = {
                food_id: cell_id.innerText,
                quantity: cell_quantity.innerText,
                price: cell_price.innerText,
            };
            tableData.push(object);
        }

        var formData = new FormData(this);
        formData.append('tableData', JSON.stringify(tableData));
        formData.append('fullAmount', parseFloat(document.getElementById("total-amount").innerText));

        // Send the data via Ajax
        var url = $(this).attr('data-action');
        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                // Clear table
                var tbody = table.getElementsByTagName("tbody")[0];
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }

                totalAmount();
                alert('Order create successfully');
            },
            error: function (xhr) {
                alert('Error');
                console.log('Error: ' + xhr.responseText);
            }
        });
    }
});