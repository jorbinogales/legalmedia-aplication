<div id="search_type">
    <div class="bg-line"></div>
    <div class="row">
        <div class="col-7 col-md-7 p-1">
            <button class="w-100 d-block m-auto radius-top-left radius-bottom-left" 
            onclick="changeSearch(event)"
            id="btn_question_form">
                Consulta casos similares al tuyo
            </button>
        </div>
        <div class="col-5 col-md-5 p-1">
            <button class="w-100 d-block m-auto radius-top-right radius-bottom-right" 
            onclick="changeSearch(event)"
            id="btn_lawyer_form">
                Busca una abogado
            </button>
        </div>
    </div>
</div>

<div id="search_form">

    <div id="lawyer_form" class="hidden">
        <h2 class="text-center m-2">¿BUSCAS UN ABOGADO?</h2>
        <form id="search_lawyer" onsubmit="Search(event)" onkeypress="PressEnter(event)">

            <div class="row">
                <div class="col-12">
                    <div class="form-group radius">
                        <input type="search" name="text" class="form-control radius" placeholder="Introduce el nombre del abogado">
                        <label class="icon icon-search" for="btn-enviar"></label>
                    </div>
                </div>
            </div>


            <p class="text-center">FILTRAR  BÚSQUEDA</p>
            <div class="row filter radius p-2">
            
                <div class="col-6 col-md-4">
                    <div class="form-group radius">
                        <label class="text">Experiencia</label>
                        <input type="number" class="form w-100 radius" min="1" max="5">
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="form-group radius">
                        <label class="text">Destacado</label>
                        <input type="number" class="form w-100 radius" min="1" max="5" name="rewards">
                    </div>
                </div>
                <div class="col-12 col-md-4 mt-5 mt-md-0">
                    <div class="form-group radius">
                        <label class="text">Materia</label>
                        <select class="form w-100 radius" id="select" name="list_skill_id">
                        </select>
                    </div>
                </div>
            </div>

            <input type="submit" value="enviar" id="btn-enviar" style="display:none">
        </form>

    </div>

    <div id="question_form" class="hidden">
     <h2 class="text-center m-2">¿TIENES UNA CONSULTA? REVISA CASOS SIMILARES</h2>
        <form id="search_question" onsubmit="Search(event)" onkeypress="PressEnter(event)">

            <div class="row">
                <div class="col-12">
                    <div class="form-group radius">
                        <input type="search" name="text" class="form-control radius" placeholder="Introduce tu caso">
                        <label class="icon icon-search" for="btn-enviar"></label>
                    </div>
                </div>
            </div>

            <input type="submit" value="enviar" id="btn-enviar" style="display:none">

        </form>

    </div>
  

</div>


<link rel="stylesheet" href="./src/css/search.css">

<script>

let activeSearch = true;

const changeSearch = (e) => {

    let laywer_form = document.getElementById('lawyer_form');
    let search_form =  document.getElementById('question_form');

    
    let btn_lawyer = document.getElementById('btn_lawyer_form');
    let btn_question =  document.getElementById('btn_question_form');

    lawyer_form.setAttribute('class', 'hidden');
    search_form.setAttribute('class', 'hidden');

    if(e != null){

        e.target.disabled = true;
        
       if(e.target.id == 'btn_lawyer_form'){
            btn_question.disabled = false;

       }  else { 

            btn_lawyer.disabled = false;

       } 

       e.target.disabled == true;
    } else { 

        btn_lawyer.disabled = true;

    }

  
    if(activeSearch){
        laywer_form.setAttribute('class', 'show');
    } else {
        search_form.setAttribute('class', 'show');
    }


    activeSearch = !activeSearch;

}

const PressEnter = async (e) => {

    if(e.keypress == "enter"){
        Search(e);
    }

}

// For Load Skills
const loadSkills = async () => {

    const response = await fetch(base_url + 'listskill');
    const dataResponse = await response.json()

    let skills = dataResponse.data;

    const select = document.getElementById('select');


    skills.forEach((skill, index) => {
        console.log(skill);
        let options = document.createElement('option');
        options.setAttribute('value', skill.id)
        options.innerHTML = skill.text;

        select.prepend(options);
    });

}


    
const Search =  async (e) => {


    e.preventDefault();
    let form = document.querySelector('#'+e.target.id);
    formData = new FormData(form);

    let responseData = [];
    await axios.post(base_url + 'search', formData)
        .then(response =>{
           try {

            responseData = response.data[0].original.data;
            let list = document.getElementById('list');
            
            list.className = 'show';
            list.innerHTML = JSON.stringify(responseData);

            } catch {

            }
        
        })
        .catch( error => {
            console.log(error);  
        });
    
    loadResults(responseData);
}

changeSearch();

loadSkills();

</script>