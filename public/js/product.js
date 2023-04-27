let productDetiles = 
{
    productName:"",
    productPrice:"",
    categoryId:"",
    isAvailable:true
}
let formErrors;

async function addNewProduct()
{
    $("adding-form").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    // prepare date to be send to the server
    var productImage = document.getElementById("productImage").files[0]
    var formData = new FormData();
    formData.append('product', JSON.stringify(productDetiles));
    formData.append("productImage", productImage);

    let addingResualt = await fetch("../controllers/add_product.php", { method: "POST", body: formData})

    if(addingResualt.ok)
    {
        const JsonResualt = await addingResualt.json();

        if(JsonResualt.status == 401)
        {
            if(!formErrors)
                formErrors = JsonResualt.errors

            for (const key in inputErrors) {
                if(inputErrors[key] == JsonResualt.errors[key])
                    $(key).innerHTML = JsonResualt.errors[key]
                else
                    $(key).innerHTML = ""

            }

        }
        else
        {
            for (const key in inputErrors) {
                $(key).innerHTML = ""
            }

            $("adding-form").reset()
            vNotify.success({text: JsonResualt.success});

        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }

}

function productDetilesBuilder(elem)
{
    productDetiles[elem.name] = elem.value
}

function $(identifer)
{
    return document.getElementById(identifer)
}
