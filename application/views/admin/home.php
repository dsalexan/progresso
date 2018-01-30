
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
<h1 class="h2">Acessos</h1>
</div>

<div class="ui top attached right aligned segment">
    <div class="ui calendar" id="rangestart" style="display: inline-block">
        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="text" placeholder="Data Inicial">
        </div>
    </div>

    <div class="ui calendar" id="rangeend" style="display: inline-block">
        <div class="ui input left icon action">
            <i class="calendar icon"></i>
            <input type="text" placeholder="Data Final">
            <div class="ui animated button" tabindex="0" id="rangesubmit">
                <div class="visible content">Mostrar</div>
                <div class="hidden content">
                    <i class="area chart icon"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dashboard" class="ui attached segment">
    <div class="ui inverted dimmer">
        <div class="ui huge text loader">Acessando Google Analytics</div>
    </div>
    <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
</div>
