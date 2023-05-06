let formErrors;
let form_data = 
{
    email:"",
    password:""
}


function userDetilesBuilder(elem)
{
    form_data[elem.name] = elem.value
}

async function loginAction()
{
    $("login_form").addEventListener('submit', event => {
        event.preventDefault();
    });
    
    var email = $("email").value;
    var Email = $("Email");
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

    var password = $("password").value;
    var Password = $("Password");
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

    var formData = new FormData();
    formData.append('data', JSON.stringify(form_data)); 
    let addingResualt = await fetch("http://localhost/ai2m_cafe/controllers/login.php",  {method: "POST", body: formData})

    
    if(addingResualt.ok)
    {
        
         const JsonResualt = await addingResualt.json();
         
        if(JsonResualt.status == 401 || JsonResualt.status == 404)
        {
            console.log(JsonResualt.errors)
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

            $("login_form").reset()
            if(JsonResualt.is_admin)
            {
                vNotify.success({ text: "Admin has been logedin Successfully", visibleDuration: 2000, fadeInterval: 20 });
                setTimeout(() => {
                    window.location.href='http://localhost/ai2m_cafe/views/admin/index.php'
                },1200)

            }
            else
            {
                vNotify.success({ text: "User has been logedin Successfully", visibleDuration: 2000, fadeInterval: 20 });
                setTimeout(() => {
                    window.location.href='http://localhost/ai2m_cafe/views/admin/index.php'
                },1200)
                 
            }

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



let popup = document.getElementById("popup");

function openpopup()
{
    popup.classList.add("open-popup");
}

let newpass = 
    {
        secretkey:"",
        newpassword:""
    }
   
function newpassDetilesBuilder(elem)
{
    newpass[elem.name] = elem.value
}


async function closepopup()
{
    let popup_Errors;
    
    
    var newpassword = $("newpassword").value;
    var NewPassword = $("Newpassword");
    var pattern_pass =  /^[a-z _]{8}$/ ;
    if(newpassword == '')
    {
        NewPassword.innerHTML = 'password is required';
    }
    else if(!pattern_pass.test(newpassword))
    {
        NewPassword.innerHTML = 'error password';
    }
    else
    {
        NewPassword.innerHTML =""
    }

    var secretkey = $("secretkey").value;
    var Secretkey = $("Secretkey");
    if(secretkey == '')
    {
        Secretkey.innerHTML = 'Secretkey is required';
    }
    else
    {
        Secretkey.innerHTML =""
    }
    
    var newData = new FormData();
    newData.append('changepass', JSON.stringify(newpass)); 
    let addResualt = await fetch("http://localhost/ai2m_cafe/controllers/changepass.php",  {method: "POST", body: newData})

    if(addResualt.ok)
    {
        
         const Resualt = await addResualt.json();
         
        if(Resualt.status == 401 || Resualt.status == 404)
        {
            console.log(Resualt.errors)
            popup_Errors = Resualt.errors
            
           
            for (const key in popup_Errors) {
                if(popup_Errors[key] == Resualt.errors[key])
                    $(key).innerHTML = Resualt.errors[key]
                else
                    $(key).innerHTML = ""

            }
        }
        else
        {
            for (const key in popup_Errors) {
                $(key).innerHTML = ""
            }

            vNotify.success({text: Resualt.success, visibleDuration: 2000, fadeInterval: 20});
            popup.classList.remove("open-popup");
        }
    }
    else
    {
        console.log("something went wrong, try again later")
    }



    
    
}


