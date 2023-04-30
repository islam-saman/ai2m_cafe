var box = document.getElementsByClassName("box");
var tbodyTable = document.getElementById("tbody-table");
var orderContainer = ``;
var orderArray = [];


for (let index = 0; index < box.length; index++) {
    box[index].addEventListener("click", () => {
        addOrder(index);
    })
}


function displayOrder() {
    orderContainer = ``;
    for (let index = 0; index < orderArray.length; index++) {
        orderContainer += `
        <tr id='${(box[index].getElementsByClassName("prdId")[0]).value}'>
            <td><span>${(box[index].getElementsByClassName("prdName")[0]).innerHTML}</span></td>
            <td><span>${(box[index].getElementsByClassName("prdPrice")[0]).innerHTML}</span></td>
            <td class="d-flex">
                <button class="btn btn-success">+</button>
                <input class="form-control mx-1" type="number" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                <button class="btn btn-danger">-</button>
            </td>
            <td></td>
            <td><i class="fa-solid fa-trash-can" onclick='deleteOrder(${(box[index].getElementsByClassName("prdId")[0]).value})'></i></td>
        </tr>
                `
    }
    tbodyTable.innerHTML = orderContainer;
}



function addOrder(index) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            newOrder = `
            <tr id='${(box[index].getElementsByClassName("prdId")[0]).value}'>
                <td><span>${(box[index].getElementsByClassName("prdName")[0]).innerHTML}</span></td>
                <td><span>${(box[index].getElementsByClassName("prdPrice")[0]).innerHTML}</span></td>
                <td class="d-flex">
                    <button class="btn btn-success">+</button>
                    <input class="form-control mx-1" type="number" style="width:30px;padding:0px;text-align:center;" name="quantity"/>
                    <button class="btn btn-danger">-</button>
                </td>
                <td></td>
                <td><i class="fa-solid fa-trash-can" onclick='deleteOrder(${(box[index].getElementsByClassName("prdId")[0]).value})'></i></td>
            </tr>
        `
            orderArray.push(newOrder);
            displayOrder();
        }
    };
    xmlhttp.open("GET", `index.php`, true);
    xmlhttp.send();
}


//your validation code
function deleteOrder(orderId) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            orderArray.splice(orderId, 1);
            displayOrder();
            console.log(orderArray);
        }

    };
    xmlhttp.open("GET", `index.php`, true);
    xmlhttp.send();

}






// console.log(tbodyTable);

