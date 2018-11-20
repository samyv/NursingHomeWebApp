<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<div class="row" onclick="onClick()">
    <div class="column">
        <h2>Room 1</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 2</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 3</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 4</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 5</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 6</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 7</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 8</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 9</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 10</h2>
        <p>Alice & Bob</p>
    </div>
</div>

<div class="row">
    <div class="column" style="width : 100%; background : #bbb; height: 100px; cursor: auto";>

    </div>
</div>

<div class="row" onclick="onClick()">
    <div class="column">
        <h2>Room 11</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 12</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 13</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 14</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 15</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 16</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 17</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 18</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 19</h2>
        <p>Alice & Bob</p>
    </div>
    <div class="column">
        <h2>Room 20</h2>
        <p>Alice & Bob</p>
    </div>
</div>

<style>
    * {
        box-sizing: border-box;
        font-family: Roboto;
    }

    /* Create two equal columns that floats next to each other */
    .column {
        background: #003b46;
        color: white;
        float: left;
        padding: 10px;
        width : 10%;
    }

    .column:hover{
        background: #009cad;
        cursor:pointer;
    }

    /* Clear floats after the columns */
    .row:after {

        content: "";
        display: table;
        clear: both;
        width : 100%
    }
</style>

<script>
    function onClick()
    {
        window.location.href = 'singleRoomView';

    }
</script>