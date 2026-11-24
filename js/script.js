document.addEventListener("DOMContentLoaded", function () {

   const userBtn = document.getElementById("user-btn");
   const userBox = document.querySelector(".user-box");
   const menuBtn = document.getElementById("menu-btn");
   const navbar = document.querySelector(".navbar");

   if(userBtn){
      userBtn.addEventListener("click", function(){
         if(userBox){
            userBox.classList.toggle("active");
         }
      });
   }

   if(menuBtn){
      menuBtn.addEventListener("click", function(){
         if(navbar){
            navbar.classList.toggle("active");
         }
      });
   }

});