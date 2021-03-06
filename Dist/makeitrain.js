/**
 * @author Neo Anderson (Blackcore.ir)
 */

/**
 * @class
 * @classdesc Time engine, this class handle all time operations. for use BlackMoneyClass you first need to make one object from this class.
 * @param {number} milliseconds The intervals (in milliseconds) on how often to execute the code. If the value is less than 10, the value 10 is used
 */
class BlackTimeClass {
    /**
     * @hideconstructor
     * @param tickRatio
     */
    constructor(tickRatio) {
        let me = this;
        me.tickRatio = tickRatio;
        me.tickTempName = 1;
        me.tickList = {};
        me.timeHandle = null;
    }
    makeTime (){
        let me = this;
        me.timeHandle = setInterval(function () {
            me.tick(me);
        },me.tickRatio);
    }

    /**
     * add a function when tick happend on this class .
     * @param callback {function} there is a list that this callback push on it and called on every tick.
     * @returns {number} handlerId that can be used for removeTick function input.
     */
    onTick (callback){
        if (!this.timeHandle)
            this.makeTime()
        this.tickList[this.tickTempName] = callback;
        return this.tickTempName++;
    }

    /**
     * remove a tick handler that added with onTick Method .
     * @param handlerId {number} this number generate in onTick method.
     */
    removeTick (name){
        delete this.tickList[name];
        if (Object.values(this.tickList).length ===0){
            clearInterval(this.timeHandle);
            this.timeHandle = null;
        }
    }
    tick (me){
        let array = Object.values(me.tickList);
        if (array.length === 0) return false;
        array.forEach(item=>{
            item();
        })
    }
}

/**
 * @class
 * @classdesc Animation Class Handle a Frame Animation.
 */
class BlackAnimationClass{
    /**
     * @hideconstructor
     * @param configs
     */
    constructor(configs) {
        this.configs = configs;
        this.currentFrame = 1;
        this.element = document.createElement('div');
        this.element.style.width = this.configs.tile_size[0]*this.configs.size+'px';
        this.element.style.height = this.configs.tile_size[1]*this.configs.size+'px';
        this.element.style.transform = 'scaleX('+this.configs.direction+')';
        this.element.style.background = 'url('+ this.configs.source +')';
        this.element.style.position = 'absolute';
        this.element.style.float = 'left';
        this.element.style.backgroundSize = this.configs.main_size[0]*this.configs.size + 'px '+ this.configs.main_size[1]*this.configs.size+'px';
        this.element.style.zIndex = 10000;
        this.element.style.opacity= 1;
        this.element.className = 'Animation';
        this.tableCurrentPostion = {row:1,col:1};
        this.onEndHandler = function () {

        };
        this.move();
        this.configs.yard.appendChild(this.element);
    }

    /**
     * move object to new position base on table.
     */
    move (){
        this.element.style.left = ( (this.configs.startPosition.x + this.configs.direction*this.configs.size*this.configs.moveRatio *this.configs.framesPosition[this.currentFrame][0]))+'px';
        this.element.style.top = ( (this.configs.startPosition.y + this.configs.size*this.configs.moveRatio *this.configs.framesPosition[this.currentFrame][1]))+'px';
    }

    /**
     * change frame.
     */
    render (){
        this.element.style.backgroundPositionX = (this.tableCurrentPostion.col-1)*this.configs.tile_size[0]*this.configs.size*-1 + 'px';
        this.element.style.backgroundPositionY = (this.tableCurrentPostion.row-1)*this.configs.tile_size[1]*this.configs.size*-1 + 'px';

        this.tableCurrentPostion.col ++;
        if (this.tableCurrentPostion.col > this.configs.table.col){
            this.tableCurrentPostion.col = 1;
            this.tableCurrentPostion.row ++;
        }
        if (this.tableCurrentPostion.row > this.configs.table.row){
            this.tableCurrentPostion.row = 1;
            this.end();
        }

    }
    /**
     * @function this function , set next position and frame to element.
     */
    nextFrame (){
        this.move();
        this.render();

        this.currentFrame ++;
        if (this.currentFrame > this.configs.endFrame)
            this.currentFrame = 1;
    }

    /**
     * @function when animation is end . after last frame this function call.
     */
    end(){
        this.onEndHandler();
    }

    /**
     * set callback to on End() function.
     * @param callback
     */
    onEnd (callback){
        this.onEndHandler = callback;
    }

    /**
     * get html element on money object.
     * @returns element {object}
     */
    getElement (){
        return this.element;
    }
}

/**
 * @class
 * @extends BlackAnimationClass
 * @classdesc Money/Paper Class.
 */
class BlackMoney extends BlackAnimationClass{
    /**
     * @param parent {object} parent element. (if you need to customize for specific element put that element here if not put document.body)
     * @param time {BlackTimeClass} time Engine
     * @param startPosition {Object} money start position.
     * @param startPosition.x {number} x position
     * @param startPosition.y {number} y position
     * @param source {string} image path like : wp/wp-content/plugins/blackcore-make-ir-rain/images/custom.png
     * @param size {number} a number between 0 and 1.
     * @param direction {number} if set -1 money throw from the left side and if 1 throw from the right side
     */
    constructor(yard, time, startPosition, image, size, direction) {
        super({
            startPosition : startPosition,
            source : image,
            main_size : [400, 272],
            tile_size : [80, 68],
            endFrame : 20,
            size : size || 1,
            direction : direction || 1,
            table : {row:4,col:5},
            moveRatio : 10.08529411764706,
            framesPosition : {
                1 : [0,0],
                2 : [2.61, -0.39],
                3 : [8.15,0.85],
                4 : [7.62,5.93],
                5 : [3.95,9.38],
                6 : [3.53,8.54],
                7 : [5.75,10.90],
                8 : [10.69,12.52],
                9 : [15.38,11.47],
                10 : [16.47,10.80],
                11 : [15.10,13.19],
                12 : [11.39,16.02],
                13 : [8.50,13.72],
                14 : [7.69,12.07],
                15 : [9.81,14.75],
                16 : [6.49,18.49],
                17 : [2.89,21.80],
                18 : [0.81,21.80],
                19 : [0.56,22.01],
                20 : [0.21,22.06],
            },
            yard : yard
        });
        let me = this;
        me.clock = time;
        me.timeHandler = me.clock.onTick(function () {
            me.nextFrame();
        });
    }

    nextFrame() {
        super.nextFrame();
        if (this.configs.endFrame - this.currentFrame < 2)
            this.element.style.opacity = (((this.configs.endFrame - this.currentFrame))*100/2)/100;
    }

    end() {
        super.end();
        this.element.remove();
        this.clock.removeTick(this.timeHandler);
    }
}