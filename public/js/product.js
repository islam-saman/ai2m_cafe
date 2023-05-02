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


function imageSizeValidation(image)
{
    if(productImage)
    {
        let imageSize = productImage.size / 1000
        
        if(imageSize > 2000)
            return false
        
        else 
            return true
    }
    else
        return "no image has been found"

}

async function addNewProduct()
{
    $("adding-form").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    // prepare date to be send to the server
    var productImage = document.getElementById("productImage").files[0]
    let validateImageSize = imageSizeValidation(productImage)
    var formData = new FormData();
    formData.append('product', JSON.stringify(productDetiles));
    
    if(validateImageSize)    
        formData.append("productImage", productImage);
    else
        vNotify.error({text: "Maxmimum size of the image is 2MB", visibleDuration: 2000, fadeInterval: 20});
    

    let addingResualt = await fetch("../../../controllers/admin/product/add_product.php", { method: "POST", body: formData})
    if(addingResualt.ok)
    {
        const JsonResualt = await addingResualt.json();
        if(JsonResualt.status == 401)
        {
            if(!formErrors)
                formErrors = JsonResualt.errors

            for (const key in formErrors)
            {
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
    let fetchingResualt = await fetch("../../../controllers/admin/product/list_products.php")
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
                    <a type="button" href='../../views/admin/product/update_product.html?prodId=${product.id}' class='btn btn-success'>Update</a>
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
    
    let deleteResualt = await fetch("../../../controllers/admin/product/delete_product.php", {
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

async function getUpdateForm()
{
    let getUpdateForm = await fetch("./add_product.html")
    let updateForm = await getUpdateForm.text()
    document.getElementById("header").innerHTML = updateForm;
    document.getElementById("subButton").removeAttribute("onclick")
    document.getElementById("subButton").addEventListener("click", updateProduct)
}

async function updateProduct()
{
    $("adding-form").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    
    // prepare date to be send to the server
    var productImage = document.getElementById("productImage").files[0]
    let validateImageSize = imageSizeValidation(productImage)
    
    const urlParams = new URLSearchParams(window.location.search);
    let productId = urlParams.get('prodId')

    var formData = new FormData()
    formData.append('product', JSON.stringify(productDetiles));
    formData.append('prodId', productId);
    
    if(validateImageSize)    
        formData.append("productImage", productImage);
    else
        vNotify.error({text: "Maxmimum size of the image is 2MB", visibleDuration: 2000, fadeInterval: 20});
    
    let updateResualt = await fetch("../../../controllers/admin/product/update_product.php", { method: "POST", body: formData})
    if(updateResualt.ok)
    {
        const JsonResualt = await updateResualt.json();
        if(JsonResualt.status == 401)
        {
            if(!formErrors)
                formErrors = JsonResualt.errors

            for (const key in formErrors)
            {
                if(formErrors[key] == JsonResualt.errors[key])
                    $(key).innerHTML = JsonResualt.errors[key]
                else
                    $(key).innerHTML = ""

            }
        }
        else if(JsonResualt.status == 404)
        {
            vNotify.error({text: JsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        }
        else
        {
            for (const key in formErrors) {
                $(key).innerHTML = ""
            }

            $("adding-form").reset()
            localStorage.setItem("productNewDetiles", JSON.stringify(JsonResualt.success))
            vNotify.success({text: JsonResualt.success, visibleDuration: 2000, fadeInterval: 20});

            setTimeout(() => {
                window.location.href = "http://localhost/ai2m_cafe/views/admin/product/products.html";
            }, 2000)
        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }


}

async function isProductAvailable(productId){

    var formData = new FormData();
    formData.append('prodId', JSON.stringify(productId));
    
    let availablityResualt = await fetch("../../../controllers/admin/product/product_availability.php", {
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
                    <a type="button" href='../../views/admin/product/update_product.html?prodId=${product.id}' class='btn btn-success'>Update</a>
                    <a type="button" onclick= "deleteProduct(${product.id})"  class='btn btn-danger'>Delete</a>
               </div>
           </td>
       </tr>        
       `

       $("tableBody").innerHTML += tableRow
       localStorage.removeItem("newProduct")
    }

})


