let container = ``;
const tbody = document.getElementById("orderData");
const tableRow = document.getElementsByClassName("tableRow");
const card = document.getElementsByClassName("card");
let isCardOpen = false;

function getAllOrders() {
    fetch('http://localhost/ai2m_cafe/controllers/admin/order.php?timestamp=' + Date.now())
        .then(async (res) => {
            let data = await res.json();
            let orders = data['orders'];
            let orders_products = data["orders_products"];
            console.log(data);
            orders.forEach(row => {
                let orderProducts = orders_products.filter(op => op.order_id === row.id);
                let productCards = '';
                orderProducts.forEach(op => {
                    productCards += `
            <td>
              <div class="card" style="width: 18rem;">
                <img src="${op.image}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h2 class="card-title">Name : ${op.name}</h2>
                  <p class="card-text">Price : ${op.price}</p>
                  <p class="card-text">Quantity : ${op.quantity}</p>
                  <p class="btn btn-primary">Sub Total : ${op.sub_total}</p>
                </div>
              </div>
            </td>
          `;
                });
                tbody.innerHTML += `
          <tr class="tableRow" id="${row["id"]}"  disabled="false">
            <td>${row['id']}</td>
            <td>${row['date']}</td>
            <td><i class="fa fa-check-circle-o green"></i><span class="ms-1">${row['status']}</span></td>
            <td><img src="https://i.imgur.com/VKOeFyS.png" width="25">${row['name']}</td>
            <td>${row['room']}</td>
            <td>${row['total']}</td>
            <td>${row['ext']}</td>
            <td class="text-end"><button class="btn btn-success" style="width: 100%" onclick="deliverOrder(${row['id']})">Deliver</button></td>
          </tr>
          <tr class="orderProductsRow" id="orderProductsRow-${row['id']}'">
            ${productCards}
          </tr>
        `;
            });
        })
        .catch((error) => console.log(error))
}
getAllOrders();

//
// function openOrderDetails(id) {
//     let element = document.getElementById(id);
//     if(element.getAttribute("disabled") == "true"){
//         return;
//     }else{
//     fetch(`http://localhost/ai2m_cafe/controllers/admin/order.php?id=${id}`)
//         .then(async (res) => {
//             let data = await res.json();
//             let orderProducts = data['order_products'];
//             console.log(data['order_products']);
//             let newRow = document.createElement('tr')
//             orderProducts.forEach(row => {
//                 let newData = document.createElement('td')
//                 newData.innerHTML = `
//                         <div class="card" style="width: 18rem;">
//                           <img src="${row['image']}" class="card-img-top" alt="...">
//                           <div class="card-body">
//                             <h2 class="card-title">Name : ${row['name']}</h2>
//                             <p class="card-text">Price : ${row['price']}</p>
//                             <p class="card-text">Quantity : ${row['quantity']}</p>
//                             <p class="btn btn-primary">Sub Total : ${row['sub_total']}</p>
//                           </div>
//                         </div>
//                 `;
//                 newRow.append(newData)
//                 // element.appendChild(newRow)
//             })
//             element.parentNode.insertBefore(newRow, element.nextSibling);
//             element.setAttribute("disabled","true")
//         })
//         .catch((error) => console.log(error));
//     }
//
// }

function deliverOrder(id){
    fetch(`http://localhost/ai2m_cafe/controllers/admin/order.php?id=${id}`)
        .then(res => res.json())
        .then(data => {
            if (data === true) {
                Swal.fire({
                    icon: 'success',
                    title: 'Order Updated!',
                    text: 'The order has been updated successfully.',
                    timer: 2000
                });
                getAllOrders(); // call getAllOrders() to update the table
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to update order.',
                    timer: 2000
                });
            }
        })
        .catch(error => console.log(error));
}


