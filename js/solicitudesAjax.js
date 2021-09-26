console.log('Archivo llamado correctamente');

$("#save").click(function(e){
  let idQ;
  let idP;
  let question=document.getElementById('question').value;
  let option1=document.getElementById('option1').value;
  let option2=document.getElementById('option2').value;
  let option3=document.getElementById('option3').value;
  let option4=document.getElementById('option4').value;
  let SendLecture=document.querySelector('#send');
  if(question.length==0 || option1.length==0 || option2.length==0 || option3.length==0 || option4.length==0){
    SendLecture.innerHTML=`
    <div class="alert alert-warning">Por favor llene todo los campos</div>
         `;
           return;
  }
   
  CrearQuiz();
})

function CrearQuiz(){
    $.ajax({
        method: 'GET',
        url: 'api/index.php',
        dataType:'json',
        data: 'crearquiz=crear',
         success: function(data1){
           console.log(data1);
          idQ=data1[0].id;
          EnviarPregunta();
         },
         error: function(error) {
           console.log('error1')
         console.log(error);
         }
        })
}


function EnviarPregunta(){
    $.ajax({
        method: "POST",
        url: "php/index.php",
        dataType:'json',
        data: {
        idQE: idQ,
        nameLE : question
        },
        success: function(data2) {
        console.log(data2);
        idP=data2;
        ObtenerIdPregunta();
        },
        error: function(error1) {
          console.log('error2')
         console.log(error1);
        }
       })
    }

function ObtenerIdPregunta(){
    $.ajax({
        method: "GET",
        url: "php/index.php",
        dataType:'json',
        data: 'obtener_idq=obtener',
        success: function(data2) {
        console.log(data2);
        GuardarOpciones();
        },
        error: function(error1) {
          console.log('error2')
         console.log(error1);
        }
       })
}

function GuardarOpciones(){
    let idP2=idP;
    $.ajax({
        method: 'POST',
  url: 'api/index.php',
  dataType:'json',
  data: {
      op1: option1,
      op2: option2,
      op3: option3,
      op4: option4,
      id_pregunta: idP2
  },
   success: function(data3){
    SendLecture.innerHTML=`
  <div class="alert alert-success">${data3}</div>
       `;
   },
   error: function(error3) {
     console.log('error3');
     console.log(error3);
    SendLecture.innerHTML=`
  <div class="alert alert-danger">No se han podido guardar las preguntas</div>
       `;
   }})
}
var exists; //function to call inside ajax callback 
function set_exists(x){ 
  exists = x; 
}
 $.ajax({ url: "check_entity_name.php", 
 type: "POST", 
 async: false, // set to false so order of operations is correct 
 data: {entity_name : entity},
  success: function(data){ 
    if(data == true){ 
      set_exists(true); 
    } 
      else{ set_exists(false);
       } 
      } 
    });
     if(exists == true){
        return true;
       } else{ 
         return false; 
        } 

        jQuery.extend ( {
           getValues: function(url) {
              var result = null; 
              $.ajax( {
                 url: url,
                  type: 'get',
                   dataType: 'html',
                    async: false,
                     cache: false,
                      success: function(data) { 
                        result = data;
                       } 
                      });
                        return result;
                       } 
                      }); 
                        // Option List 1, when "Cats" is selected elsewhere 
                        optList1_Cats += $.getValues("/MyData.aspx?iListNum=1&sVal=cats"); 
                        // Option List 1, when "Dogs" is selected elsewhere 
                        optList1_Dogs += $.getValues("/MyData.aspx?iListNum=1&sVal=dogs"); 
                        // Option List 2, when "Cats" is selected elsewhere 
                        optList2_Cats += $.getValues("/MyData.aspx?iListNum=2&sVal=cats"); 
                        // Option List 2, when "Dogs" is selected elsewhere 
                        optList2_Dogs += $.getValues("/MyData.aspx?iListNum=2&sVal=dogs"); 
