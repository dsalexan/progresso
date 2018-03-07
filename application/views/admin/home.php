
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
            <div class="computer-only ui animated button rangesubmit" tabindex="0">
                <div class="visible content">Mostrar</div>
                <div class="hidden content">
                    <i class="area chart icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-only ui animated button rangesubmit" tabindex="0">
        <div class="visible content">Mostrar</div>
        <div class="hidden content">
            <i class="area chart icon"></i>
        </div>
    </div>
</div>

<div id="dashboard" class="ui attached segment">
    <div class="ui inverted dimmer">
        <div class="ui huge text loader">Acessando Google Analytics</div>
    </div>
    <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
</div>

</br>
</br>
<div class="ui grid">
    <div class="six wide computer sixteen wide mobile column">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h3>Origem de Tráfego</h3>
        </div>
    
        <div id="traffic_table" class="ui basic blurring segment dimmable dimmed">
            
            <div class="ui active inverted dimmer">
                <div class="ui text loader">Acessando Google Analytics</div>
            </div>

            <table class="ui table unstackable small">
                <thead>
                    <tr>
                        <th>Origem</th>
                        <th>Acessos</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <i class="folder icon"></i> ectmjr.com.br
                        </td>
                        <td>42</td>
                    </tr>
                    <tr>
                        <td>
                            <i class="folder icon"></i> unifesp.com.br
                        </td>
                        <td>52</td>
                    </tr>
                    <tr>
                        <td>
                            <i class="folder icon"></i> progressoveiculos.com.br
                        </td>
                        <td>81</td>
                    </tr>
                </tbody>
            </table>

        </div>

    </div>
    <div class="ten wide column">

    </div>
</div>