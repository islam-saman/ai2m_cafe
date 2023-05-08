var box = document.getElementsByClassName("box");
var tbodyTable = document.getElementById("tbody-table");
var orderContainer = ``;
var orderArray = [];
const prdId = document.getElementById("prdId");
let prd;
let prdList = [];
let users;
let user_id = 0;
let userContainer = ``;
let userArray = [];
let user_dropdown = document.getElementById("user_dropdown");

function getProductsForUser(){
    fetch(`http://localhost/ai2m_cafe/controllers/user/get_products.php`)
        .then(async (res)=> {
            data = await res.json();
            if (data['redirect']){
                console.log("login");
                window.location.href = '../../views/login.php';
            }else{
                prdList = data["prd"];
                user_id=data["user_id"];

                displayProduct();
            }
    });
}getProductsForUser();


function getProductsForAdmin(){
    fetch(`http://localhost/ai2m_cafe/controllers/admin/home.php`)
        .then(async (res)=> {
            data = await res.json();
            if (data['redirect']){
                console.log("login");
                window.location.href = '../../views/login.php';
            }else{
                prdList = data["prd"];
                user_id=data["user_id"];
                displayProduct();
            }
        });
}getProductsForAdmin();





function displayProduct(){
    const productCard = document.getElementById("prd-box");
    let productContainer = ``;

    for (const p of prdList) {
        productContainer += `
         <div class='box' onclick='addOrder(${p.id})'> 
            <input class='prdId' name='prdId' type='hidden' value=${p.id} />
            <div class='image'>
                <a style='cursor:pointer;'> 
                    <img class='w-100' style='height:150px;border-radius:10px'  src="../../public/images/products/${p.image}" alt='${p.id}'>
                </a>
            </div>
            <div class='content'>
                <h3 class='prdName'>${p.name}</h3>
                <div class='stars'>
                    <i class='fas fa-star'></i>
                    <i class='fas fa-star'></i>
                    <i class='fas fa-star'></i>
                    <i class='fas fa-star'></i>
                    <i class='fas fa-star-half-alt'></i>
                    <span> (50) </span>
                </div>
                <div>
                    <span class='prdPrice'>${p.price}</span> 
                </div>
            </div>
        </div>    `
    }
    productCard.innerHTML = productContainer;
}


function displayOrder() {
    orderContainer = ``;
    for (const prd in orderArray){
        orderContainer += `
                        <tr scope="row" id="${orderArray[prd].product['id']}">
                           <td>${orderArray[prd].product['name']}</td>
                           <td>${orderArray[prd].product['price']}</td>
                           <td class="d-flex">
                               <a onclick="increaseOrderQuantity(${orderArray[prd].product['id']}, ${orderArray[prd].product['price']})" class="btn btn-success">+</a>
                               <input class="form-control mx-1" disabled type="number" id="ordQun${orderArray[prd].product['id']}" value="${orderArray[prd].quantity}" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                               <a onclick="decreaseOrderQuantity(${orderArray[prd].product['id']}, ${prd['price']})" class="btn btn-danger">-</a>
                           </td>
                           <td id="subTotal${orderArray[prd].product['id']}">${Number(orderArray[prd].quantity) * Number(orderArray[prd].product['price'])}</td>
                           <td style="cursor: pointer"><i class="fa-solid fa-trash-can mt-1" onclick='deleteOrder(${orderArray[prd].product['id']})'></i></td>
                        </tr>  
        `
    }
    tbodyTable.innerHTML = orderContainer;
}


async function addOrder(index) {
    fetch(`http://localhost/ai2m_cafe/controllers/user/user_order.php?id=${index}`)
        .then(async (res)=> {
            prd = await res.json();

            let foundOrder = false;
            for (const prdEl of orderArray) {
                if(prdEl.product.id == prd['id']){
                    foundOrder = true;
                    // let orderQuantity = document.getElementById(`ordQun${prd['id']}`);
                    // let increasePrdValue  = Number(orderQuantity.value) + 1;
                    // orderQuantity.value = increasePrdValue;
                    increaseOrderQuantity(`${prd.id}`,`${prd.price}`)
                    break;
                }
            }
            if(!foundOrder){
                let newOrder = `
                       <tr id="${prd['id']}">
                           <td><span>${prd['name']}</span></td>
                           <td><span>${prd['price']}</span></td>
                           <td class="d-flex">
                               <a onclick="increaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-success">+</a>
                               <input disabled class="form-control mx-1" type="number" id="ordQun${prd['id']}" value="1" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                               <a onclick="decreaseOrderQuantity(${prd['id']}, ${prd['price']})" class="btn btn-danger">-</a>
                           </td>
                           <td id="subTotal${prd['id']}">${Number(prd['price'])}</td>
                           <td><i class="fa-solid fa-trash-can" style="margin-top: 3px" onclick='deleteOrder(${prd['id']})'></i></td>
                       </tr>               
                    `;
                orderContainer += newOrder;
                orderArray.push({product: prd, quantity: 1, subTotal: Number(prd['price'])});
                displayOrder();
                calcTotalPrice();
            }
            // console.log(orderArray)
        })
}


function increaseOrderQuantity(orderId, orderPrice) {
    for (const prdEl of orderArray) {
        if(prdEl.product.id == orderId){
            let orderQuantity = document.getElementById(`ordQun${orderId}`);
            prdEl.quantity++;
            orderQuantity.value = (prdEl.quantity).toString();
            let subTotal = document.getElementById(`subTotal${prdEl.product['id']}`);
            subTotal.innerHTML = (Number(prdEl.quantity) * Number(orderPrice)).toString();
            prdEl.subTotal = Number(prdEl.quantity) * Number(orderPrice);
            break;
        }
    }
    calcTotalPrice();
}


function decreaseOrderQuantity(orderId, orderPrice){
    for (const prdEl of orderArray) {
        if(prdEl.product.id == orderId){
            let orderQuantity = document.getElementById(`ordQun${orderId}`);
            prdEl.quantity--;

            if(prdEl.quantity === 0){
                deleteOrder(prdEl.product.id);
                orderQuantity.value = prdEl.quantity;
                prdEl.subTotal = 0;
                break;
            }

            orderQuantity.value = prdEl.quantity;
            let subTotal = document.getElementById(`subTotal${prdEl.product['id']}`);
            subTotal.innerHTML = (Number(prdEl.quantity) * Number(prdEl.product.price)).toString();
            prdEl.subTotal = Number(prdEl.quantity) * Number(prdEl.product.price);
            break;

        }
    }
    calcTotalPrice()
}


function calcTotalPrice(){
    let total = 0;
    let totalPrice = document.getElementById("totalPrice");

    for (const el of orderArray){
        let ordQun = document.getElementById(`ordQun${el.product.id}`);

        total += ( Number(ordQun.value) * Number(el.product.price));
    }
    totalPrice.innerHTML  = total.toString();
}


function deleteOrder(orderId) {
    orderArray2 = orderArray.splice(orderArray.findIndex( item => item.product.id  === orderId),1);
    orderContainer = ``;
    displayOrder();
    calcTotalPrice();
}


function deleteAllOrders(){
    orderContainer = ``;
    orderArray = [];

    /*COMMENT*/
    let comment = document.getElementById("user_comment");
    comment.value = ``;

    /*EXT*/
    let ext = document.getElementById("ext");
    ext.value = ``;

    /*ROOM NUMBER*/
    let roomNumber = document.getElementById("room_number");
    roomNumber.value = ``;

    displayOrder();
    calcTotalPrice();
}


function addOrderForUser(){
    fetch(`http://localhost/ai2m_cafe/controllers/admin/add_order_for_user.php`)
        .then(async (res)=> {
            users = await res.json();
            displayUsers()
        });
}
addOrderForUser();

function displayUsers(){
    userContainer = `<option selected disabled value="">Please select user</option>`
    for (const user of users) {
        userContainer += `
              <option value="${user.id}">${user.name}</option>
        `
        userArray.push(user);
    }
    user_dropdown.innerHTML = userContainer
}


/*Remember There is no validation on user id [ADMIN ONLY] -----> DO NOT FORGET*/
function getUserId(event){
    user_id = event.target.value;
}


async function order(){
    document.getElementById("submit_order").addEventListener('submit', event => {
        event.preventDefault();
    });

    if(orderArray.length === 0){
        let submitOrderBtn = document.getElementById("submit_order_btn");
        submitOrderBtn.style.display = "block";
        return;
    }else{
        let submitOrderBtn = document.getElementById("submit_order_btn");
        submitOrderBtn.style.display = "none";
    }

    /*COMMENT*/
    let comment = document.getElementById("user_comment");

    /*TOTAL PRICE*/
    let totalPrice = document.getElementById("totalPrice");

    /*EXT*/
    let ext = document.getElementById("ext");

    /*ROOM NUMBER*/
    let roomNumber = document.getElementById("room_number");

    let data = {
        date:  "1997-09-12",
        room: roomNumber.value.toString(),
        ext: Number(ext.value),
        user_id: user_id,
        total: Number(totalPrice.innerHTML),
        comment: comment.value
    }

    let formData = new FormData();
    formData.append("data", JSON.stringify(data));
    let orderId;
    fetch(`http://localhost/ai2m_cafe/controllers/user/add_order.php`,{
        method:"POST",
        body: formData,
    }).then(async (res)=> {
        orderId = await res.json();

        for (const selectedProduct of orderArray){
            let ordPrd = {
                order_id: orderId,
                product_id: selectedProduct.product.id,
                quantity: selectedProduct.quantity,
                sub_total:selectedProduct.subTotal
            }

            let orderProduct = new FormData();
            orderProduct.append("ordPrd", JSON.stringify(ordPrd));

            fetch(`http://localhost/ai2m_cafe/controllers/user/add_order_product.php`,{
                method:"POST",
                body: orderProduct,
            }).then(async (res)=> {
                await res.json()
                deleteAllOrders();
            });
        }
    });
}