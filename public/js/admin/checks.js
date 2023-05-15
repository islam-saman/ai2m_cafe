async function getUsers(userId)
{
    if(!userId)
        userId = ""
        
    let fetchingResualt = await fetch(`../../controllers/admin/checks/list_users.php?userId=${userId}`)
    return fetchingResualt.json()
}

async function loadUsersList()
{
    let usersList = await getUsers()
    usersList.forEach(user => {

        let userOption = `<option value="${user.id}">${user.name}</option>`  
        $("usersList").innerHTML += userOption
    })
}

async function displayUsers(elem)
{

    let userId;
    let usersList;

    if(elem)
    {
        userId = elem.value
        usersList = await getUsers(userId)
    }
    else
        usersList = await getUsers()

    
    $("tableBody").innerHTML = ""
    usersList.forEach(user => {

        const tableRow = 
        `
        <tr id="${user.id}">     
            <td onclick="displayUserOrder(${user.id})">${user.name}</td>
            <td>${user.totalAmount}</td>
        </tr>        
        `
        $("tableBody").innerHTML += tableRow

    });

}

async function displayUserOrder(userId) {

    let fetchingResualt = await fetch(`../../controllers/admin/checks/user_orders_checks.php?userId=${userId}`)
    let userOrders = await  fetchingResualt.json()
    $("orderData").innerHTML = ""
    userOrders.forEach(order => {

        const tableRow = 
        `
        <tr id="${order.id}">     
            <td onclick="openOrderDetails(${order.id})">${order.date}</td>
            <td>${order.total}</td>
        </tr>        
        `
        $("orderData").innerHTML += tableRow

    });    
}

function $(identifer)
{
    return document.getElementById(identifer)
}

function fnLoader()
{
    loadUsersList()
    displayUsers()    
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
                await drawTable(res);
            })
            .catch((error) => console.log(error));
    }
}
