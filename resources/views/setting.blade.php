@extends('layouts.app')
@extends('layouts.sidebar')

@section('content')
<style>
  
.color-picker > fieldset {
  border: 0;
  display: flex;
  gap: 2rem;
  width: fit-content;

  padding: 1rem 3rem;
  margin-inline: auto;
  border-radius: 0 0 1rem 1rem;
}

.color-picker input[type="radio"] {
  appearance: none;
  width: 1.5rem;
  height: 1.5rem;
  outline: 3px solid var(--radio-color, currentColor);
  outline-offset: 3px;
  border-radius: 50%;
}
.color-picker{
  display: block !important;
  margin-left: 100px;
  margin-top: 10%;
}
.color-picker input[type="radio"]:checked {
  background-color: var(--radio-color);
}

.color-picker input[type="radio"]#red {
  --radio-color: #e34057;
}
/* e663b8 */
.color-picker input[type="radio"]#pink {
  --radio-color: #e663b8;
}
.color-picker input[type="radio"]#blue {
  --radio-color: #5B99C2;
}
.color-picker input[type="radio"]#green {
  --radio-color: #55AD9B ;
}
.color-picker input[type="radio"]#dark {
  --radio-color: #686D76;
}
.color-picker input[type="radio"]#light {
  --radio-color: #F8EDED;
}
h1{
  margin-left: 50%;
  color: var(--title);
}

</style>


<h1 >Temas</h1>







    @endsection