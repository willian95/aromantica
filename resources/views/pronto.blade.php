<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" type="image/png" href="{{ url('/assets/img/logo.png') }}"/>

<div class="soon">
    <img class="soon-img" src="https://images.unsplash.com/photo-1557827999-c0bb00bbee13?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=755&q=80" alt="">

    <div class="mask">
        <img class="logo" src="{{ asset('assets/img/logo.png') }}" alt="">
       <div class="lines">
        <div class="line"></div>
        <h1> Muy pronto! </h1>
        <div class="line2"></div>
       </div>
    </div>

</div>

<style>
    .lines{
        display: flex;
    justify-content: center;
    align-items: center;
    }
    .logo{
        width: 35%;
    }
    .soon h1{
        font-family: 'Varela Round', sans-serif;
    position: relative;
    margin: 0px 30px;
    color: #ffffff;
    text-transform: uppercase;
    margin-top: 3px;
    text-shadow: 0px 0px 10px black;
    }
    .line{
 
        content: "";
    width: 100px;
    height: 5px;
    background: white;
    box-shadow: 0px 0px 10px #00000061;
    border-radius: 10px;
   
    }
    .line2{
       
        content: "";
    width: 100px;
    height: 5px;
    background: white;
    box-shadow: 0px 0px 10px #00000061;
    border-radius: 10px;
   
    }
    .mask{
        position:absolute;
        background: #ffffff99;
        width: 100%;
        top: 0;
        height: 100%;
        display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    align-content: center;
    }
    .soon{
        position: relative;
        text-align: center;
        height: 100vh;
    overflow: hidden;
  
    }
    .soon-img{
        width: 100%;
        height: 100vh;
        object-fit: cover
    }
    *{
        margin: 0;
        padding: 0;
    }
    @media (min-width: 0px) and (max-width: 767px) {
        
        .logo {
            width: 100%;
        }
    }


</style>