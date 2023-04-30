var box = document.getElementsByClassName("box");
var tbodyTable = document.getElementById("tbody-table");
var orderContainer = ``;
var orderArray = [];
const prdId = document.getElementById("prdId").value;


function displayOrder() {
    tbodyTable.innerHTML = orderContainer;
}


async function addOrder(index) {
    fetch(`http://localhost:8080/ai2m_cafe/controllers/user/user_order.php?id=${index}`)
        .then(async (res)=> {
            const prd = await res.json();
            // console.log(prd.name)

            let foundOrder = false;
            for (const prdEl of orderArray) {
                if(prdEl.id == prd['id']){
                    foundOrder = true;
                    // let orderQuantity = document.getElementById(`ordQun${prd['id']}`);
                    // let increasePrdValue  = Number(orderQuantity.value) + 1;
                    // orderQuantity.value = increasePrdValue;
                    increaseOrderQuantity(`${prd['id']}`,`${prd['price']}`)
                    break;
                }
            }
            if(!foundOrder){
                let newOrder = `
                       <tr ${prd['id']}>
                           <td><span>${prd['name']}</span></td>
                           <td><span>${prd['price']}</span></td>
                           <td class="d-flex">
                               <a onclick="increaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-success">+</a>
                               <input class="form-control mx-1" type="number" id="ordQun${prd['id']}" value="1" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                               <a onclick="decreaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-danger">-</a>
                           </td>
                           <td id="subTotal${prd['id']}">${Number(prd['price'])}</td>
                           <td><i class="fa-solid fa-trash-can" onclick='deleteOrder(${prd['id']})'></i></td>
                       </tr>               
                    `;
                orderContainer += newOrder;
                orderArray.push(prd);
                displayOrder();
                calcTotalPrice();
            }
            // console.log(orderArray)
        })
}


function increaseOrderQuantity(orderId, orderPrice) {
    for (const prdEl of orderArray) {
        if(prdEl.id == orderId){
            let orderQuantity = document.getElementById(`ordQun${orderId}`);
            let increasePrdValue  = Number(orderQuantity.value) + 1;
            orderQuantity.value = increasePrdValue;
            let subTotal = document.getElementById(`subTotal${prdEl['id']}`);
            subTotal.innerHTML = (Number(increasePrdValue) * Number(orderPrice)).toString();
            break;
        }
    }
    calcTotalPrice();
}


function decreaseOrderQuantity(orderId, orderPrice){
    for (const prdEl of orderArray) {
        if(prdEl.id == orderId){
            let orderQuantity = document.getElementById(`ordQun${orderId}`);
            if (Number(orderQuantity.value) > 0){
                let decreasePrdValue  = Number(orderQuantity.value) - 1;
                if(decreasePrdValue == 0){
                    deleteOrder(orderId);
                }
                orderQuantity.value = decreasePrdValue;
                let subTotal = document.getElementById(`subTotal${prdEl['id']}`);
                subTotal.innerHTML = (Number(decreasePrdValue) * Number(orderPrice)).toString();
                break;
            }
        }
    }
}


function calcTotalPrice(){
    let total = 0;
    let totalPrice = document.getElementById("totalPrice");

    for (const el of orderArray){
        let ordQun = document.getElementById(`ordQun${el.id}`);
        console.log(ordQun.value)
        total += ( Number(ordQun.value) * Number(el.price)) ;
    }
    console.log(total)
    totalPrice.innerHTML  = "Total Price <b>$" + total.toString() + ".00</b>";
}


function deleteOrder(orderId) {
    orderArray = orderArray.filter( el => el.id != orderId );
    console.log(orderArray)
    orderContainer = ``;
    for(const prd of orderArray){
        orderContainer += ` 
                    <tr ${prd['id']}>
                           <td><span>${prd['name']}</span></td>
                           <td><span>${prd['price']}</span></td>
                           <td class="d-flex">
                               <a onclick="increaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-success">+</a>
                               <input class="form-control mx-1" type="number" id="ordQun${prd['id']}" value="1" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                               <a onclick="decreaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-danger">-</a>
                           </td>
                           <td id="subTotal${prd['id']}">${Number(prd['price'])}</td>
                           <td><i class="fa-solid fa-trash-can" onclick='deleteOrder(${prd['id']})'></i></td>
                    </tr>`;
    }
    displayOrder();
    calcTotalPrice();
}


function deleteAllOrders(){
    orderContainer = ``;
    orderArray = [];
    displayOrder();
    calcTotalPrice();
}

