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

            $("adding-form").reset()
            vNotify.success({text: JsonResualt.success, visibleDuration: 2000, fadeInterval: 20});

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
                <div class="btn-group" role="group">
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
        vNotify.success({text: jsonResualt, visibleDuration: 2000, fadeInterval: 20});
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

        // for (const key in product) {
            
        //     const tableColumn = document.createElement("td")
        //     if(key == "image")
        //     {
        //         const productImage = document.createElement("img")
        //         productImage.src = product[key];
        //         tableColumn.appendChild(productImage)
        //     }

        //     if (key == "is_available" && product[key] == 1)
        //         product[key] = "Yes"
        //     else if (key == "is_available" && product[key] == 0)
        //         product[key] = "No"

        //     tableColumn.innerText =  product[key]
        //     tableRow.appendChild(tableColumn)
        // }