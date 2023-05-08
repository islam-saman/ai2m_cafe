let formErrors;
let data = 
{
    secretkey:""
}

async function display(){
    
    show = document.getElementById("body_data");
    var formData = new FormData();
    formData.append('alldata', JSON.stringify("select")); 

    let alldata = await fetch("../../controllers/admin/allUser.php",  {method: "POST", body:formData })

    if(alldata.ok)
    {
        const JsonResualt = await alldata.json();
        console.log(JsonResualt)
        if(JsonResualt.status == 401 || JsonResualt.status == 404)
        {
            console.log("something went wrong, try again later")
        }
        else
        {
              firstshow = "<div class='container'> <div class='d-flex justify-content-between my-5'> <h1>All User</h1> <a href='addUser.php' class='btn btn-primary h1'>Add new user </a></div><ul class='responsive-table'><li class='table-header'><div class='col col-1'>Name</div><div class='col col-1'>Room</div><div class='col col-1'>SecretKey</div><div class='col col-3'>Image</div><div class='col col-4'>Action</div></li> ";
              
                if(JsonResualt.alldata != 'empty')
                {
                    for(let i=0;i<JsonResualt.alldata.length;i++) {
                        firstshow += ' <li class="table-row d-flex justify-content-between align-items-center unimation"> ';
                        firstshow +=  `<div class='col col-1 h4' data-label='Job Id'>${JsonResualt.alldata[i].name}</div>`;
                        firstshow +=  `<div class='col col-1 h4' data-label='Job Id'>${JsonResualt.alldata[i].room_no}</div>`;   
                        firstshow +=  `<div class='col col-1 h4' data-label='Job Id'>${JsonResualt.alldata[i].secret_key}</div>`;   
                        firstshow +=  `<div class='col col-3 ms-4' data-label='Job Id'><img width='50' height='50'  src='../${JsonResualt.alldata[i].profile_picture}'></div>`;
                        firstshow +=  `<div class='col col-4' data-label='Job Id'><a class=' btn btn-warning m-2' href='editUser.php?data=${JsonResualt.alldata[i].secret_key}'  >Edit</a><a class=' btn btn-danger' href='#' onclick='deleteuser(${JsonResualt.alldata[i].secret_key})' >Delete</a></div></li>`;
                          console.log()     
                      }
                      firstshow +="</ul>";
                      firstshow +="</div>";
                }
              
           
            
              show.innerHTML = firstshow;

            
        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }
    

}


display()



async function deleteuser(secret_key)
{
    data["secretkey"] = secret_key;

    var formData = new FormData();
    formData.append('data', JSON.stringify(data)); 

    let deleteResualt = await fetch("../../controllers/admin/deleteUser.php",  {method: "POST", body:formData })

    if(deleteResualt.ok)
    {
        const JsonResualt = await deleteResualt.json();
        if(JsonResualt.status == 401 || JsonResualt.status == 404)
        {
            console.log("something went wrong, try again later")
        }
        else
        {
            
            vNotify.success({text: JsonResualt.success, visibleDuration: 2000, fadeInterval: 20});
            setTimeout(() => {
                display();
            },1200)
             
        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }


}


