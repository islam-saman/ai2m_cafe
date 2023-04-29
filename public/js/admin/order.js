let container = ``;
const tbody = document.getElementById("orderData");
const tableRow = document.getElementsByClassName("tableRow");
const card = document.getElementsByClassName("card");
let isCardOpen = false;

function getAllOrders() {
    fetch('http://localhost/ai2m_cafe/controllers/admin/order.php')
        .then(async (res) => {
            let data = await res.json();
            console.log("orders",data['orders'])
            let orders = data['orders'];
            let orders_products = data["orders_products"];
            orders.forEach(row => {
                tbody.innerHTML += `
                    <tr class="tableRow" id="${row["id"]}" onclick="openOrderDetails(${row['id']})" disabled="false">
                        <td>${row['id']}</td>
                        <td>${row['date']}</td>
                        <td><i class="fa fa-check-circle-o green"></i><span class="ms-1">${row['status']}</span></td>
                        <td><img src="https://i.imgur.com/VKOeFyS.png" width="25">${row['name']}</td>
                        <td>${row['room']}</td>
                        <td>${row['total']}$</td>
                        <td class="text-end"><span class="fw-bolder">${row['ext']}</span></td>
                    </tr>`;
            });
        })
        .catch((error) => console.log(error))
}

getAllOrders();

function openOrderDetails(id) {
    let element = document.getElementById(id);
    if(element.getAttribute("disabled") == "true"){
        return;
    }else{
    fetch(`http://localhost/ai2m_cafe/controllers/admin/order.php?id=${id}`)
        .then(async (res) => {
            let data = await res.json();
            let orderProducts = data['order_products'];
            console.log(data['order_products']);
            let newRow = document.createElement('tr')
            orderProducts.forEach(row => {
                let newData = document.createElement('td')
                newData.innerHTML = `
                        <div class="card" style="width: 18rem;">
                          <img src="${row['image']}" class="card-img-top" alt="...">
                          <div class="card-body">
                            <h2 class="card-title">Name : ${row['name']}</h2>
                            <p class="card-text">Price : ${row['price']}</p>
                            <p class="card-text">Quantity : ${row['quantity']}</p>
                            <p class="btn btn-primary">Sub Total : ${row['sub_total']}</p>
                          </div>
                        </div>
                `;
                newRow.append(newData)
                // element.appendChild(newRow)
            })
            element.parentNode.insertBefore(newRow, element.nextSibling);
            element.setAttribute("disabled","true")
        })
        .catch((error) => console.log(error));
    }

}

