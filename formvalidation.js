function validateForm(){


var rtned=true;
rtned=validatefname();
if(rtned==true)

rtned=validatelname();
if(rtned==true)

rtned=validatephone_number();
if(rtned==true)


rtned=validateemail();
if(rtned==true)

    //commissioner
rtned=validatenational_id();
if(rtned==true)
   
rtned=validatecounty_id();    
if(rtned==true)

//deputy commissioner
rtned=validatesubcounty_id();    
if(rtned==true)

rtned=validatecommissioner();    
if(rtned==true)

//supervisor
rtned=validatedeputy_commissioner_id();    
if(rtned==true)

rtned=validatecounty_id();    
if(rtned==true)

//censor officer

rtned=validatesupervisor_id();    
if(rtned==true)

//censordata

rtned=validatehousehold_id();    
if(rtned==true)

rtned=validateage();    
if(rtned==true)

rtned=validategender();
if(rtned==true)

rtned=validatemarital_status();
if(rtned==true)

rtned=validatefamily_size();    
if(rtned==true)

rtned=validateeducation();    
if(rtned==true)

rtned=validatereligion();    
if(rtned==true)

rtned=validateoccupation();    
if(rtned==true)

rtned=validateemployment_status();    
return rtned;

rtned=validateaccess_to_electricity();    
if(rtned==true)

rtned=validateaccess_to_water();    
if(rtned==true)

rtned=validateassets();    
if(rtned==true)

rtned=validatetribe();    
if(rtned==true)

rtned=validateresidential_status();    
if(rtned==true)

rtned=validatecensusofficer_id();    
return rtned;

}//end of validate form

//validate first name
function validatefname(){
if(document.getElementById("fname").value.length==0){
alert("You must enter a valid First name");
document.getElementById("fname").focus();
return false;
}else
return true;
}

//Validating Last Name Filed
function validatelname(){
if(document.getElementById("lname").value.length==0){
alert("You must enter a valid Last name");
document.getElementById("lname").focus();
return false;
}else
return true;
}

//Validating phone number
function validatephone_number(){
phone_number=document.getElementById("phone_number").value;
if(phone_number.length!=10 || isNaN(phone_number)){
alert("You must enter a valid phone Number");
document.getElementById("phone_number").focus();
return false;
}
else
return true;
}

function validateemail(){
email=document.getElementById("email").value;
if(email.length==0 || email.indexOf("@")==-1|| email.indexOf(".")==-1)
{alert("You must enter a valid email");
document.getElementById("email").focus();
return false;
}else
return true;
}


function validatenational_id(){
national_id=document.getElementById("national_id").value;
if(national_id.length!==7 || isNaN(national_id)){
alert("You must enter a valid national ID Number");
document.getElementById("national_id").focus();
return false;
}else
return true;
}



function validatecounty_id(){
county_id=document.getElementById("county_id").value;
if(county_id.length==0 || isNaN(county_id)){
alert("You must enter a valid county ID Number");
document.getElementById("county_id").focus();
return false;
}
else
return true;
}

//deputy_commissioner 


function validatesubcounty_id(){
subcounty_id=document.getElementById("subcounty_id").value;
if(subcounty_id.length==0 || isNaN(subcounty_id)){
alert("You must enter a valid subcounty ID Number");
document.getElementById("subcounty_id").focus();
return false;
}
else
return true;
}


function validatecommissioner_id(){
commissioner_id=document.getElementById("commissioner_id").value;
if(commissioner_id.length==0 || isNaN(commissioner_id_id)){
alert("You must enter a valid commissioner ID Number");
document.getElementById("commissioner_id").focus();
return false;
}
else
return true;
}

//supervisor 
function validateward_id(){
ward_id=document.getElementById("ward_id").value;
if(ward_id.length==0 || isNaN(ward_id)){
alert("You must enter a valid ward ID Number");
document.getElementById("ward_id").focus();
return false;
}
else
return true;
}

function validatedeputy_commissioner_id(){
deputy_commissioner_id=document.getElementById("deputy_commissioner_id").value;
if(deputy_commissioner_id.length==0 || isNaN(deputy_commissioner_id)){
alert("You must enter a valid deputy commissioner ID Number");
document.getElementById("deputy_commissioner_id").focus();
return false;
}
else
return true;
}

//censor officer
function validatesupervisor_id(){
supervisor_id=document.getElementById("supervisor_id").value;
if(supervisor_id.length==0 || isNaN(supervisor_id)){
alert("You must enter a valid supervisor ID Number");
document.getElementById("supervisor_id").focus();
return false;
}
else
return true;
}

//userregistration
function validatename(){
name=document.getElementById("name").value;
if(name.length==0 ){
alert("You must enter a valid name");
document.getElementById("name").focus();
return false;
}
else
return true;
}

function validaterole(){
    index=document.getElementById("role").options.selectedIndex;
    if(index==0){
        alert("you must select your role");
        return false;
    }else
        return true;
}

function validateusername(){
username=document.getElementById("username").value;
if(username.length==0 ){
alert("You must enter a valid username");
document.getElementById("username").focus();
return false;
}
else
return true;
}

function validatepassword(){
password=document.getElementById("password").value;
if(password.length==0 ){
alert("You must enter a password");
document.getElementById("password").focus();
return false;
}
else
return true;
}

//censordata

function validatehousehold_id(){
household_id=document.getElementById("household_id").value;
if(household_id.length==0 || isNaN(household_id)){
alert("You must your household id");
document.getElementById("household_id").focus();
return false;
}
else
return true;
}





function validateage(){
age=document.getElementById("age").value;
if(age.length==0 || isNaN(age)){
alert("You must enter a valid age");
document.getElementById("age").focus();
return false;
}
else
return true;
}

function validategender(){
gender=document.getElementById("gender").value;
if(gender.length==0){
alert("You must a gender");
document.getElementById("gender").focus();
return false;
}
else
return true;
}

function validatemarital_status(){
marital_status=document.getElementById("marital_status").options.selectedIndex;
if(marital_status==0){
alert("You must select your marital status");
return false;
}else
return true;
}

function validatefamily_size(){
family_size=document.getElementById("family_size").value;
if(family_size.length==0 || isNaN(family_size)){
alert("enter your family size");
document.getElementById("family_size").focus();
return false;
}
else
return true;
}

function validateeducation(){
education=document.getElementById("education").options.selectedIndex;
if(education==0){
alert("You must select your education level");
return false;
}else
return true;
}


function validatereligion(){
religion=document.getElementById("religion").options.selectedIndex;
if(religion==0){
alert("You must select your religion");
return false;
}else
return true;
}


function validateoccupation(){
occupation=document.getElementById("occupation").value;
if(occupation.length==0 ){
alert("enter your occupation");
document.getElementById("occupation").focus();
return false;
}
else
return true;
}


function validateemployment_status(){
employment_status=document.getElementById("employment_status").options.selectedIndex;
if(employment_status==0){
alert("You must select your employment status");
return false;
}else
return true;
}


function validateaccess_to_electricity(){
YES=document.getElementById("YES").checked;
NO=document.getElementById("NO").checked;
if(YES==false && NO==false){
alert("We need to know whether you have access to electricity ");
return false;
}else
return true;
}

function validateaccess_to_water(){
YES=document.getElementById("YES").checked;
NO=document.getElementById("NO").checked;
if(YES==false && NO==false){
alert("We need to know whether you have access to water");
return false;
}else
return true;
}


function validateassets(){
assets=document.getElementById("assets").value;
if(assets.length==0 ){
alert("You must enter your assets");
document.getElementById("assets").focus();
return false;
}
else
return true;
}

function validatetribe(){
tribe=document.getElementById("tribe").value;
if(tribe.length==0 ){
alert("You must your tribe");
document.getElementById("tribe").focus();
return false;
}
else
return true;
}

function validateresidential_status(){
residential_status=document.getElementById("residential_status").options.selectedIndex;
if(residential_status==0){
alert("You must select your residential status");
return false;
}else
return true;
}


function validatecensusofficer_id(){
censusofficer_id=document.getElementById("censusofficer_id").value;
if(censusofficer_id.length==0 || isNaN(co_id)){
alert("You must your censor officer's Id");
document.getElementById("censusofficer_id").focus();
return false;
}
else
return true;
}


