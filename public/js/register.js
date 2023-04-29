let formErrors;
let user = 
{
    Name:"",
    email:"",
    password:"",
    ConfirmPassword:"",
    Room:"",
    Ext:"",
}



function userDetilesBuilder(elem)
{
    user[elem.name] = elem.value
}



async function adduser()
{
    $("add_user").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    
    var name = $("name").value;
    var Name = $("Name");
    if(name == '')
    {
        Name.innerHTML = 'Name is required';
    }
    else if(name.length < 4)
    {
        Name.innerHTML = 'Name must be at least 4 characters';
    }
    else if(name.length > 45)
    {
        Name.innerHTML = 'Name not exceed 45 characters'; 
    }
    else
    {
        console.log("scnbsjubcsaikcnsiopxsbcipasbc")
        Name.innerHTML =""
    }
    
    var email = $("user_email").value;
    var Email = $("email");
    var pattern_email =  /^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ ;
    if(email == '')
    {
        Email.innerHTML = 'email is required';
    }
    else if(!pattern_email.test(email))
    {
        Email.innerHTML = 'email must match example@example.com';
    }
    else
    {
        Email.innerHTML =""
    }
    
    var password = $("user_password").value;
    var Password = $("password");
    var pattern_pass =  /^[a-z _]{8}$/ ;
    if(password == '')
    {
        Password.innerHTML = 'password is required';
    }
    else if(!pattern_pass.test(password))
    {
        Password.innerHTML = 'error password';
    }
    else
    {
        Password.innerHTML =""
    }
      

    var cpassword = $("cpassword").value;
    var ConfirmPassword = $("ConfirmPassword");
    if(cpassword == '')
    {
        ConfirmPassword.innerHTML = 'confirmPassword is required';
    }
    else if(cpassword != password)
    {
        ConfirmPassword.innerHTML = 'Confirm_Password not matched';
    }
    else
    {
        ConfirmPassword.innerHTML =""
    }


    var Room_No = $("Room_No").value;
    var Room = $("Room");
    if(Room_No == '')
    {
        Room.innerHTML = 'Room is required';
    }
    else
    {
        Room.innerHTML =""
    }

    var ext = $("ext").value;
    var Ext = $("Ext");
    if(ext == '')
    {
        Ext.innerHTML = 'Ext is required';
    }
    else
    {
            Ext.innerHTML =""
        }
        
    var userImage = document.getElementById("image").files[0]
     var formData = new FormData();
     formData.append('user', JSON.stringify(user)); 

    if(userImage)
    {
        
        let imageSize = userImage.size / 1000
        
        if(imageSize > 2000)
        {
            vNotify.error({text: "Maxmimum size of the image is 2MB", visibleDuration: 2000, fadeInterval: 20});
            return
        }
        else 
        {
          formData.append("userImage", userImage);
        }
    }
    else 
    {
      formData.append("userImage", userImage);
    }

    let addingResualt = await fetch("../../controllers/register.php",  {method: "POST", body: formData})


    if(addingResualt.ok)
    {
        
         const JsonResualt = await addingResualt.json();
         
        if(JsonResualt.status == 401 || JsonResualt.status == 404)
        {
            console.log(JsonResualt.errors);
            formErrors = JsonResualt.errors
            console.log(formErrors);
           
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

            $("add_user").reset()
            vNotify.success({text: JsonResualt.success, visibleDuration: 2000, fadeInterval: 20});

        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }
}


function $(identifer)
{
    return document.getElementById(identifer)
}








