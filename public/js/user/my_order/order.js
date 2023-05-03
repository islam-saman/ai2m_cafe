
const tbody = document.getElementById("orderData");
const tableRow = document.getElementsByClassName("tableRow");
const table = document.querySelector("table");
const card = document.getElementsByClassName("card");
console.log("HI")

function getAllOrders() {
    fetch('http://localhost/ai2m_cafe/controllers/user/my_order/order.php')
        .then(async (res) => {
            drawTable(res);
        })
        .catch((error) => console.log(error))
}
//
getAllOrders();

function openOrderDetails(id) {
    let element = document.getElementById(id);
    if(element.getAttribute("disabled") == "true"){
        return;
    }else{
        fetch(`http://localhost/ai2m_cafe/controllers/user/my_order/order.php?id=${id}`)
            .then(async (res) => {
                let data = await res.json();
                let orderProducts = data;
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

function filterOrders() {
    const startDate = document.getElementById("start").value
    const endDate = document.getElementById("end").value
    let errorMessage = document.getElementById("error-message");
    if (startDate === "" || endDate === "") {
        if (!errorMessage) {
            errorMessage = document.createElement("p")
            errorMessage.id = "error-message"
            errorMessage.classList.add("alert", "alert-danger")
            table.parentNode.insertBefore(errorMessage, table)
        }
        errorMessage.innerHTML = "Please select both start and end dates.";
    } else {
        if (errorMessage) {
            errorMessage.remove();
        }
        fetch(`http://localhost/ai2m_cafe/controllers/user/my_order/order.php?start=${startDate}&end=${endDate}`)
            .then(async (res)=>{
                tbody.innerHTML="";
                drawTable(res);
            })
            .catch((error) => console.log(error));
    }
}

async function  drawTable(res){
    let data = await res.json();
    if(!data["message"]){
        let orders = data['orders'];
        orders.forEach(row => {
            tbody.innerHTML += `
                    <tr class="tableRow" id="${row["id"]}"  disabled="false">
                        <td>
                        <div class="d-flex justify-content-around">
                             <p>${row['id']}</p>
                             <div><i onclick="openOrderDetails(${row['id']})" class="fa fa-plus-circle" aria-hidden="true"></i></div>            
                        </div>
                        </td>
                        <td>${row['date']}</td>
                        <td><i class="fa fa-check-circle-o green"></i><span class="ms-1">${row['status']}</span></td>
                        <td><img src="https://i.imgur.com/VKOeFyS.png" width="25">${row['name']}</td>
                        <td>${row['room']}</td>
                        <td>${row['total']}$</td>
                        <td class="text-end"><span class="fw-bolder">${row['ext']}</span></td>
                    </tr>`;
        });
    }else{
        let msg = data["message"];
        console.log(msg);
        tbody.innerHTML = `<tr class="tableRow" id="0"  disabled="true">
                            <td colspan="7"><p class="fs-1 fw-bold text-center alert alert-danger"> ${msg} </p></td>
                        </tr>`;
    }

}
