
let image_user = document.getElementById("image-user");
let username = document.getElementById("username");


function logout(){
    fetch("http://localhost/ai2m_cafe/helpers/logout.php")
}

function getUserData(){
    fetch("http://localhost/ai2m_cafe/controllers/getUserDataFromSession.php")
        .then(async (res)=>{
            let userData = await res.json();
            image_user.setAttribute("src","../../public/uploads/"+userData["image"]);
            username.innerHTML = userData["name"];
        })
}
getUserData();
