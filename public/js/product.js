/* Start handling add product */

let formErrors;
let productDetiles = 
{
    productName:"",
    productPrice:"",
    categoryId:"",
    isAvailable:true
}

/* General helper function */

// gathering product detiles values from user inputs
function productDetilesBuilder(elem)
{
    productDetiles[elem.name] = elem.value
}

// validite image
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
        const jsonResualt = await addingResualt.json();
        if(jsonResualt.status == 200)
        {
            for (const key in formErrors) {
                $(key).innerHTML = ""
            }

            localStorage.setItem("newProduct", JSON.stringify(jsonResualt.success))
            $("adding-form").reset()
            vNotify.success({text: "Product has been added successfully", visibleDuration: 2000, fadeInterval: 20});

            setTimeout(() => {
                window.location.href = "http://localhost/ai2m_cafe/views/admin/product/products.php";
            }, 2000)            
        }
        else if(jsonResualt.status == 400)
        {
            if(!formErrors)
                formErrors = jsonResualt.errors

            for (const key in formErrors)
            {
                if(formErrors[key] == jsonResualt.errors[key])
                    $(key).innerHTML = jsonResualt.errors[key]
                else
                    $(key).innerHTML = ""

            }
        }
        else if(jsonResualt.status == 404)
            vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        else
        {
            vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
            setTimeout(() => {
                window.location.href = "http://localhost/ai2m_cafe/views/login.php";
            }, 2500)  
        }

    }
    else
    {
        console.log("something went wrong, try again later")
    }

}


async function displayProducts()
{
    let fetchingResualt = await fetch("../../../controllers/admin/product/list_products.php")
    const jsonResualt = await fetchingResualt.json();
    
    if(jsonResualt.status != 200)
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)  
    }
    else
    {

        let productList = jsonResualt.productList
        productList.forEach(product => {

            let prodDetiles = JSON.stringify(product);

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
                    <img src="../../../${product.image}" style='width: 71px; border-radius: 7px;'>
                </td>
                <td>
                    <div  id="btn-container"  class="btn-group" role="group">
                        <a type="button" onclick= "isProductAvailable(${product.id})"  class='btn btn-danger'>${isAvailableButton}</a>
                        <a type="button"  href='update_product.php?prodId=${product.id}'  onclick="getProductData(${product.id})" class='btn btn-success'>Update</a>
                        <a type="button" onclick= "deleteProduct(${product.id})"  class='btn btn-danger'>Delete</a>
                    </div>
                </td>
            </tr>        
            `

            $("tableBody").innerHTML += tableRow

        });
    }

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
    if(jsonResualt.status == 200)
    {
        $(productId).remove()
        vNotify.success({text: "The product has been deleted successfully", visibleDuration: 2000, fadeInterval: 20});
    }
    else if(jsonResualt.status == 404)
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)          
    }

}

async function getUpdateForm()
{
    loadCategoriesList()
    let getUpdateForm = await fetch("./add_product.php")
    let updateForm = await getUpdateForm.text()
    document.getElementById("header").innerHTML = updateForm;
    document.getElementById("subButton").removeAttribute("onclick")
    document.getElementById("subButton").addEventListener("click", updateProduct)
    document.title = "update product"
    
    setTimeout(()=> {
        setProductData()
    }, 100)
}

function getProductData(prodId)
{
    let productDetiles = {};   
    productDetiles.name = $(prodId).children[0].innerHTML
    productDetiles.price = $(prodId).children[1].innerHTML
    productDetiles.categoryId = $(prodId).children[2].innerHTML
    localStorage.setItem("productData", JSON.stringify(productDetiles))
}

function setProductData()
{
    let prdocutInfo = localStorage.getItem("productData")
    if(prdocutInfo)
    {
        let product = JSON.parse(prdocutInfo)

        $("productName").value = product.name
        $("productPrice").value = product.price.replace(' EG','')
        
        productDetiles.productName = product.name
        productDetiles.productPrice = product.price.replace(' EG','')
        productDetiles.categoryId = product.categoryId

        Array.from($("productCateogry").children).forEach(elm => {

            if(elm.value == product.categoryId)
            {
                elm.setAttribute("selected", "true")
            }
        })

    }
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
        const jsonResualt = await updateResualt.json();
        if(jsonResualt.status == 200)
        {
            for (const key in formErrors) {
                $(key).innerHTML = ""
            }

            localStorage.setItem("productNewDetiles", JSON.stringify(jsonResualt.success))
            $("adding-form").reset()
            vNotify.success({text: "Product has been updated successfully", visibleDuration: 2000, fadeInterval: 20});

            setTimeout(() => {
                window.location.href = "http://localhost/ai2m_cafe/views/admin/product/products.php";
            }, 2000)            
        }
        else if(jsonResualt.status == 400)
        {
            if(!formErrors)
                formErrors = jsonResualt.errors

            for (const key in formErrors)
            {
                if(formErrors[key] == jsonResualt.errors[key])
                    $(key).innerHTML = jsonResualt.errors[key]
                else
                    $(key).innerHTML = ""

            }
        }
        else if(jsonResualt.status == 404)
            vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        else
        {
            vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
            setTimeout(() => {
                window.location.href = "http://localhost/ai2m_cafe/views/login.php";
            }, 2500)  
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
    if(jsonResualt.status == 200)
    {
        availableButtonText = jsonResualt.success ? "Available" : "Unavailable"
        $(productId).querySelector("#btn-container").firstElementChild.innerText = availableButtonText
        vNotify.success({text: `The product now is ${availableButtonText}`, visibleDuration: 2000, fadeInterval: 20});
    }
    else if(jsonResualt.status == 404)
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)          
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
               <img src="../../../${product.image}" style='width: 71px; border-radius: 7px;'>
           </td>
           <td>
               <div id="btn-container" class="btn-group" role="group">
                    <a type="button" onclick= "isProductAvailable(${product.id})"  class='btn btn-danger'>${isAvailableButton}</a>
                    <a type="button" href='update_product.php?prodId=${product.id}' class='btn btn-success'>Update</a>
                    <a type="button" onclick= "deleteProduct(${product.id})"  class='btn btn-danger'>Delete</a>
               </div>
           </td>
       </tr>        
       `

       $("tableBody").innerHTML += tableRow
       localStorage.removeItem("newProduct")
    }

})



/* Start handling add category */

let categoryName = "";
function getCategoryValue(elem)
{
    categoryName = elem.value
}


async function getCategories()
{
    let fetchingResualt = await fetch("../../../controllers/admin/category/list_categories.php")
    return fetchingResualt.json()
}

async function loadCategoriesList()
{
    let cateList = await getCategories()
    cateList.forEach(cate => {

        let cateOption = `<option value="${cate.id}">${cate.name}</option>`  
        $("productCateogry").innerHTML += cateOption
    })
}


async function displayCateories()
{

    let cateList = await getCategories()
    cateList.forEach(cate => {

        const tableRow = 
        `
        <tr id="${cate.id}">
        <td>
            <input disabled value="${cate.id}"  name="cateId" class="form-control text-center" >
        </td>        
            <td>
                <input readonly value="${cate.name}"  name="cateName" class="form-control text-center" >
            </td>
            <td>
                <div  id="btn-container"  class="btn-group" role="group">
                    <a type="button" onclick='updateCategory(${cate.id})' class='btn btn-success'>Update</a>
                    <a type="button" onclick= "deleteCategory(${cate.id})"  class='btn btn-danger'>Delete</a>
                    <a type="button" onclick= "lockInput(${cate.id})"  class='btn btn-outline-dark'>
                        <i id="open-update" class="fa-solid fa-lock"></i>
                    </a>
                </div>
            </td>
        </tr>        
        `
        $("tableBody").innerHTML += tableRow

    });

}

async function addCategory()
{
    var formData = new FormData();
    formData.append('cateName', categoryName);
    console.log("hi")
    let availablityResualt = await fetch("../../../controllers/admin/category/add_category.php", {
        method: "POST",
        body: formData
    }) 

    let jsonResualt = await availablityResualt.json()
    if(jsonResualt.status == 200)
    {
        $("cateError").innerHTML = ""
        let newProductCategory = `<option value="${jsonResualt.success.id}">${jsonResualt.success.name}</option>`
        $("productCateogry").innerHTML += newProductCategory
        vNotify.success({text: `The category "${categoryName}" has been added`, visibleDuration: 2000, fadeInterval: 20});        
    }
    else if(jsonResualt.status == 400)
        $("cateError").innerHTML = jsonResualt.errors.cateError

    else if(jsonResualt.status == 404 || jsonResualt.status == 409)
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
    
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)          
    }
}


async function deleteCategory(cateId)
{
    var formData = new FormData();
    formData.append('cateId', cateId);
    
    let deleteResualt = await fetch("../../../controllers/admin/category/delete_category.php", {
        method: "POST",
        body: formData
    })

    let jsonResualt = await deleteResualt.json()
    if(jsonResualt.status == 200)
    {
        $(cateId).remove()
        vNotify.success({text: "The category has been deleted successfully", visibleDuration: 2000, fadeInterval: 20});
    }
    else if(jsonResualt.status == 404)
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)          
    }

}

let isInputUpdated = false
let isInputLocked = true
let inputOldValue;

function lockInput(cateId)
{
    if(isInputLocked)
    {
        inputOldValue = $(cateId).children[1].firstElementChild.value
        $(cateId).children[1].firstElementChild.removeAttribute("readonly")
        $(cateId).children[1].firstElementChild.focus()
        $(cateId).querySelector("#open-update").setAttribute("class","fa-solid fa-lock-open")
        isInputLocked = false

        vNotify.info({text: "Updating has been opned  <i class='fa-solid fa-lock-open'></i> ",
          visibleDuration: 2000, fadeInterval: 20})
    }
    else
    {
        if(!isInputUpdated)
            $(cateId).children[1].firstElementChild.value = inputOldValue

        $(cateId).children[1].firstElementChild.setAttribute("readonly", true)
        $(cateId).querySelector("#open-update").setAttribute("class","fa-solid fa-lock")
        isInputLocked = true
        
        vNotify.info({text: "Updating has been Locked  <i class='fa-solid fa-lock'></i> ",  visibleDuration: 2000, fadeInterval: 20})
    }

}


async function updateCategory(cateId)
{
    cateNewValue = $(cateId).children[1].firstElementChild.value

    if(isInputLocked)
    {
        vNotify.warning({text: "Please open the <i class='fa-solid fa-lock'></i> first", visibleDuration: 2000, fadeInterval: 20});
        return
    }

    if(cateNewValue == inputOldValue)
    {
        vNotify.info({text: "No change to apply", visibleDuration: 2000, fadeInterval: 20})
        return
    }


    let formData = new FormData();
    formData.append('cateId', cateId);
    formData.append('cateName', cateNewValue);
    
    let deleteResualt = await fetch("../../../controllers/admin/category/update_category.php", {
        method: "POST",
        body: formData
    })

    let jsonResualt = await deleteResualt.json()
    if(jsonResualt.status == 200)
    {
        vNotify.success({text: "The category has been updated successfully", visibleDuration: 2000, fadeInterval: 20})
        isInputUpdated = true
        lockInput(cateId)
    }
    else if(jsonResualt.status == 404)
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
    }
    else
    {
        vNotify.error({text: jsonResualt.error, visibleDuration: 2000, fadeInterval: 20});
        setTimeout(() => {
            window.location.href = "http://localhost/ai2m_cafe/views/login.php";
        }, 2500)          
    }
}