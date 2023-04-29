let formErrors;
let productDetiles = 
{
    productName:"",
    productPrice:"",
    categoryId:"",
    isAvailable:true
}

function productDetilesBuilder(elem)
{
    productDetiles[elem.name] = elem.value
}


async function addNewProduct()
{
    $("adding-form").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    // prepare date to be send to the server
    var productImage = document.getElementById("productImage").files[0]
    var formData = new FormData();
    formData.append('product', JSON.stringify(productDetiles));
    
    
    if(productImage)
    {
        let imageSize = productImage.size / 1000
        
        if(imageSize > 2000)
        {
            vNotify.error({text: "Maxmimum size of the image is 2MB", visibleDuration: 2000, fadeInterval: 20});
            return
        }
        else 
        {
          formData.append("productImage", productImage);
        }
    }


    let addingResualt = await fetch("../../controllers/product/add_product.php", { method: "POST", body: formData})
    if(addingResualt.ok)
    {
        const JsonResualt = await addingResualt.json();
        if(JsonResualt.status == 401)
        {
            if(!formErrors)
                formErrors = JsonResualt.errors

            for (const key in formErrors) {
                if(formErrors[key] == JsonResualt.errors[key])
                    $(key).innerHTML = JsonResualt.errors[key]
                else
                    $(key).innerHTML = ""

            }
        }
        else
        {
            for (const key in formErrors) {
                $(key).innerHTML = ""
            }

            localStorage.setItem("newProduct", JSON.stringify(JsonResualt.success))
            $("adding-form").reset()
            vNotify.success({text: "product has been added succesfully", visibleDuration: 2000, fadeInterval: 20});

        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }

}

async function getProductsList()
{
    let fetchingResualt = await fetch("../../controllers/product/list_products.php")
    return fetchingResualt.json()
}


async function displayProducts()
{
    let productList = await getProductsList()
    productList.forEach(product => {


        let isAvailableButton;
        if(product.is_available)
            isAvailableButton = "Available"
        else
            isAvailableButton = "Unavailable"

        const tableRow = 
        `
        <tr id="${product.id}">
            <td>${product.name}</td>
            <td>${product.price} EG</td>
            <td>${product.category_id}</td>
            <td>
                <img src="../../${product.image}" style='width: 71px; border-radius: 7px;'>
            </td>
            <td>
                <div  id="btn-container"  class="btn-group" role="group">
                    <a type="button" onclick= "isProductAvailable(${product.id})"  class='btn btn-danger'>${isAvailableButton}</a>
                    <a type="button" href='../../views/product/update_product.html?prodId=${product.id}' class='btn btn-success'>Update</a>
                    <a type="button" onclick= "deleteProduct(${product.id})"  class='btn btn-danger'>Delete</a>
                </div>
            </td>
        </tr>        
        `

        $("tableBody").innerHTML += tableRow

    });

}

async function deleteProduct(productId)
{
    var formData = new FormData();
    formData.append('prodId', JSON.stringify(productId));
    
    let deleteResualt = await fetch("../../controllers/product/delete_product.php", {
        method: "POST",
        body: formData
    })

    let jsonResualt = await deleteResualt.json()
    if(deleteResualt.status == 200)
    {
        $(productId).remove()
        vNotify.success({text: "The product has been deleted successfully", visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});

    }

}

async function isProductAvailable(productId){

    var formData = new FormData();
    formData.append('prodId', JSON.stringify(productId));
    
    let availablityResualt = await fetch("../../controllers/product/product_availability.php", {
        method: "POST",
        body: formData
    }) 

    let jsonResualt = await availablityResualt.json()
    if(availablityResualt.status == 200)
    {
        availableButtonText = jsonResualt.success ? "Available" : "Unavailable"
        $(productId).querySelector("#btn-container").firstElementChild.innerText = availableButtonText
        vNotify.success({text: `The product now is ${availableButtonText}`, visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});

    }
}

function $(identifer)
{
    return document.getElementById(identifer)
}



// expriment ... just try to memic angular live update
window.addEventListener("focus", () => {

    let newProduct = localStorage.getItem("newProduct")
    if(newProduct)
    {
        let product = JSON.parse(newProduct)

        let isAvailableButton;
        if(product.is_available)
            isAvailableButton = "Available"
        else
            isAvailableButton = "Unavailable"

        const tableRow = 
        `
       <tr id="${product.id}">
           <td>${product.name}</td>
           <td>${product.price} EG</td>
           <td>${product.category_id}</td>
           <td>
               <img src="../../${product.image}" style='width: 71px; border-radius: 7px;'>
           </td>
           <td>
               <div id="btn-container" class="btn-group" role="group">
                    <a type="button" onclick= "isProductAvailable(${product.id})"  class='btn btn-danger'>${isAvailableButton}</a>
                    <a type="button" href='../../views/product/update_product.html?prodId=${product.id}' class='btn btn-success'>Update</a>
                    <a type="button" onclick= "deleteProduct(${product.id})"  class='btn btn-danger'>Delete</a>
               </div>
           </td>
       </tr>        
       `

       $("tableBody").innerHTML += tableRow
       localStorage.removeItem("newProduct")
    }

})