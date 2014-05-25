/*
 * My97 DatePicker 4.72 Release
 * License: http://www.my97.net/dp/license.asp
 */
var $c;
//FireFox 扩展
if ($FF) {
    Event.prototype.__defineSetter__("returnValue", function(v){
        if (!v) {
            this.preventDefault();
        }
        return v;
    });  
    Event.prototype.__defineGetter__("srcElement", function(){
        var node = this.target;
        while (node.nodeType != 1) {
            node = node.parentNode;
        }
        return node;
    });
    HTMLElement.prototype.attachEvent = function(sType, fHandler){
		var shortTypeName = sType.replace(/on/, "");
		fHandler._ieEmuEventHandler = function(e){
			window.event = e;
			return fHandler();
		};
		this.addEventListener(shortTypeName, fHandler._ieEmuEventHandler, false);
	};
}

function My97DP(){
	//初始化变量
	$c = this;
	//初始化快速选择数组
	this.QS = [];
	//创建控件HTML
	$d = document.createElement('div');
	$d.className = "WdateDiv";
	//$d.onmousedown = hideSel;
	
	$d.innerHTML = '<div id=dpTitle><div class="navImg NavImgll"><a href="###"></a></div><div class="navImg NavImgl"><a href="###"></a></div><div style="float:left"><div class="menuSel MMenu"></div><input class=yminput></div><div style="float:left"><div class="menuSel YMenu"></div><input class=yminput></div><div class="navImg NavImgrr"><a href="###"></a></div><div class="navImg NavImgr"><a href="###"></a></div><div style="float:right"></div></div><div style="position:absolute;overflow:hidden"></div><div></div><div id=dpTime><div class="menuSel hhMenu"></div><div class="menuSel mmMenu"></div><div class="menuSel ssMenu"></div><table cellspacing=0 cellpadding=0 border=0><tr><td rowspan=2><span id=dpTimeStr></span>&nbsp;<input class=tB maxlength=2><input value=":" class=tm readonly><input class=tE maxlength=2><input value=":" class=tm readonly><input class=tE maxlength=2></td><td><button id=dpTimeUp></button></td></tr><tr><td><button id=dpTimeDown></button></td></tr></table></div><div id=dpQS></div><div id=dpControl><input class=dpButton id=dpClearInput type=button><input class=dpButton id=dpTodayInput type=button><input class=dpButton id=dpOkInput type=button></div>';
		
	attachTabEvent($d, function(){
		hideSel();
	});
	
	//建立对象指针
	_initPoint();
	
	//焦点的顺序
	$dp.focusArr = [document, $d.MI, $d.yI, $d.HI, $d.mI, $d.sI, $d.clearI, $d.todayI, $d.okI];
	
	for (var i = 0; i < $dp.focusArr.length; i++) {
		var currCtrl = $dp.focusArr[i];
		currCtrl.nextCtrl = i == $dp.focusArr.length - 1 ? $dp.focusArr[1] : $dp.focusArr[i + 1];
		$dp.attachEvent(currCtrl, 'onkeydown', _tab);
	}
	
	//初始化
	this.init();
	
	_initNavImg();
	
	_inputBindEvent('y,M,H,m,s');
	
	$d.upButton.onclick = function(){
		updownEvent(1)
	};
	$d.downButton.onclick = function(){
		updownEvent(-1);
	};
	
	//单击常用按钮
	$d.qsDiv.onclick = function(){
		if ($d.qsDivSel.style.display != "block") {
			$c._fillQS();
			showB($d.qsDivSel);
		}
		else {
			hide($d.qsDivSel);
		}
	};
	
	//将对象添加到document
	document.body.appendChild($d);
	
	
	//建立对象指针
	function _initPoint(){
		var as = gets('a');
		divs = gets('div'), ipts = gets('input'), btns = gets('button'), spans = gets('span');
	
		$d.navLeftImg = as[0];
		$d.leftImg = as[1];
		$d.rightImg = as[3];
		$d.navRightImg = as[2];
		
		$d.rMD = divs[9];
		
		$d.MI = ipts[0];
		$d.yI = ipts[1];

		$d.titleDiv = divs[0];
		$d.MD = divs[4];
		$d.yD = divs[6];

		$d.qsDivSel = divs[10];

		$d.dDiv = divs[11];

		$d.tDiv = divs[12];

		$d.HD = divs[13];

		$d.mD = divs[14];

		$d.sD = divs[15];

		$d.qsDiv = divs[16];

		$d.bDiv = divs[17];
		$d.HI = ipts[2];
		$d.mI = ipts[4];
		$d.sI = ipts[6];
		$d.clearI = ipts[7];
		$d.todayI = ipts[8];
		$d.okI = ipts[9];

		$d.upButton = btns[0];
		$d.downButton = btns[1];

		$d.timeSpan = spans[0];
		
		function gets(s){
			return $d.getElementsByTagName(s);
		}
	}
	
	function _initNavImg(){
		$d.navLeftImg.onclick = function(){
			$ny = $ny <= 0 ? $ny - 1 : -1;
			if ($ny % 5 == 0) {
				$d.yI.focus();
				return;
			}
			$d.yI.value = $dt.y - 1;
			$d.yI.onblur();
		};
		$d.leftImg.onclick = function(){
			$dt.attr('M', -1);
			$d.MI.onblur();
		};
		$d.rightImg.onclick = function(){
			$dt.attr('M', 1);
			$d.MI.onblur();
		};
		$d.navRightImg.onclick = function(){
			$ny = $ny >= 0 ? $ny + 1 : 1;
			if ($ny % 5 == 0) {
				$d.yI.focus();
				return;
			}
			$d.yI.value = $dt.y + 1;
			$d.yI.onblur();
		};
	}
	
	
}

My97DP.prototype = {
	init: function(){
		//初始化 $ny
		$ny = 0;
		$dp.cal = this;
		if ($dp.readOnly && $dp.el.readOnly != null) {
			$dp.el.readOnly = true;
			$dp.el.blur();
		}
		//载入皮肤
		_setActiveCSS();
				
		//处理格式字符串 此函数会创建realFmt
		this._dealFmt();
				
		$dt = this.newdate = new DPDate();
		//今天
		$tdt = new DPDate();
		//已选中的时间
		$sdt = this.date = new DPDate();
		
		this.dateFmt = this.doExp($dp.dateFmt);
		
		//初始化
		this.autoPickDate = $dp.autoPickDate == null ? ($dp.has.st && $dp.has.st ? false : true) : $dp.autoPickDate;

		$dp.autoUpdateOnChanged = $dp.autoUpdateOnChanged == null ? ($dp.isShowOK && $dp.has.d ? false : true) : $dp.autoUpdateOnChanged;
				
		//初始化 正则
		this.ddateRe = this._initRe('disabledDates');
		this.ddayRe = this._initRe('disabledDays');
		this.sdateRe = this._initRe('specialDates');
		this.sdayRe = this._initRe('specialDays');
		
		this.minDate = this.doCustomDate($dp.minDate, $dp.minDate != $dp.defMinDate ? $dp.realFmt : $dp.realFullFmt, $dp.defMinDate);
		this.maxDate = this.doCustomDate($dp.maxDate, $dp.maxDate != $dp.defMaxDate ? $dp.realFmt : $dp.realFullFmt, $dp.defMaxDate);
		//保证minDate<maxDate
		if (this.minDate.compareWith(this.maxDate) > 0) {
			$dp.errMsg = $lang.err_1;
		}
		
		if (this.loadDate()) {
			this._makeDateInRange();

			this.oldValue = $dp.el[$dp.elProp];
		}
		else {
			this.mark(false, 2);
		}
		
		//赋初值
		_setAll($dt);
		
		$d.timeSpan.innerHTML = $lang.timeStr;
		$d.clearI.value = $lang.clearStr;
		$d.todayI.value = $lang.todayStr;
		$d.okI.value = $lang.okStr;
		
		$d.okI.disabled = !$c.checkValid($sdt);
		
		this.initShowAndHide();
				
		this.initBtn();
		
		if ($dp.errMsg) {
			alert($dp.errMsg);
		}
		
		//填充Day 或 快速日期,并调整大小
		this.draw();		
		
		if ($dp.el.nodeType == 1 && $dp.el['My97Mark'] === undefined) {
			$dp.attachEvent($dp.el, 'onkeydown', _tab);
			$dp.attachEvent($dp.el, 'onblur', function(){
				if ($dp.dd.style.display == 'none') {
					$c.close();
					//触发onchange事件
					if ($dp.cal.oldValue != $dp.el[$dp.elProp] && $dp.el.onchange) {
						fireEvent($dp.el, 'change');
					}
				}
			});
		}
		
		$c.currFocus = $dp.el;
		
		hideSel();
	
		function _setActiveCSS(){
			var i, a;
			for (i = 0; (a = document.getElementsByTagName("link")[i]); i++) {
				if (a["rel"].indexOf("style") != -1 && a["title"]) {
					a.disabled = true;
					if (a["title"] == $dp.skin) 
						a.disabled = false;
				}
			}
		}
	},
	
	//保证日期在限定的访问之内,如果大于最大值则自动等于最大值,如果小于最小值自动等于最小值
	_makeDateInRange: function(){
		var rv = this.checkRange();//, isInRange = true;
		if (rv != 0) { //在区间内 什么也不做
		//	isInRange = false;
			var dt;
			if (rv > 0) {//大于	
				dt = this.maxDate;
			}
			else {//小于
				dt = this.minDate;
			}
			//调整值
			if ($dp.has.sd) {
				$dt.y = dt.y;
				$dt.M = dt.M;
				$dt.d = dt.d;
			}
			if ($dp.has.st) {
				$dt.H = dt.H;
				$dt.m = dt.m;
				$dt.s = dt.s;
			}
		}
		//return isInRange;
	},
	
	splitDate: function(str, fmt, y, M, d, H, m, s, b3x){
		var dt;
		if (str && str.loadDate) {
			dt = str;
		}
		else {
			dt = new DPDate();
			if (str != '') {
				fmt = fmt || $dp.dateFmt;
				var i, offset = 0, match, tokenRe = /yyyy|yyy|yy|y|MMMM|MMM|MM|M|dd|d|%ld|HH|H|mm|m|ss|s|DD|D|WW|W|w/g;
			
				var g = fmt.match(tokenRe);
				
				tokenRe.lastIndex = 0;
				
				if (b3x) {
					match = str.split(/\W+/);
				}
				else {
					var ii = 0, reg = '^';
					
					while ((match = tokenRe.exec(fmt)) !== null) {
						//alert('fmt:'+fmt+'\nii:'+ii+'\nindex:'+match.index+'match:'+match)
						if(ii>=0)
							reg +=fmt.substring(ii,match.index);
						
						//ii = match.index - ii;
						//reg += (ii == 0) ? '' : ('\\W{' + ii + '}');
						ii = tokenRe.lastIndex;
						
						switch (match[0]) {
							case 'yyyy':
								reg += '(\\d{4})';
								break;
							case 'yyy':
								reg += '(\\d{3})';
								break;
							case 'MMMM':
							case 'MMM':
							case 'DD':
							case 'D':
								reg += '(\\D+)';
								break;
							default:
								//if (new RegExp('MMMM|MMM|DD|D|WW|W|w').test(match[0])) {
								//	reg += '(\\D+)';
								//}
								//else {
									reg += '(\\d\\d?)';
								//}
								break;
						}
					}
					
					reg += '.*$';
					//alert(reg)
					//v和f的length不相等,利用产生的正则进行匹配
					match = new RegExp(reg).exec(str);
					//alert('reg=' + reg + '\n' + match)
					offset = 1;
				}
				
				if (match) {
					for (i = 0; i < g.length; i++) {
						var v = match[i + offset];
						if (v) {
							switch (g[i]) {
								case 'MMMM':
								case 'MMM':
									dt.M = getMonth(g[i],v);
									break;
								case 'y':
								case 'yy':
									v = pInt2(v, 0);
									if (v < 50) {
										v += 2000;
									}
									else {
										v += 1900;
									}
									dt.y = v;
									break;
								case 'yyy':
									dt.y = pInt2(v, 0) + $dp.yearOffset;
									break;
								default:
									dt[g[i].slice(-1)] = v;
									break;
							}
						}
					}
				}
				else {
					dt.d = 32;
				}
			}
		}

		dt.coverDate(y, M, d, H, m, s);
		//alert(dt.y+' '+dt.M+' '+dt.d + ' ' +dt.H +' ' + dt.m + ' '+dt.s);
		return dt;
		
		function getMonth(fmt, v){
			var arr = fmt == 'MMMM' ? $lang.aLongMonStr : $lang.aMonStr;
			for (var i = 0; i < 12; i++) {
				if (arr[i].toLowerCase() == v.substr(0, arr[i].length).toLowerCase()) 
					return i + 1;
			}
			//返回一个不合法的月份
			return -1;
		}
	},
	
	//p = $dp.disabledDates disabledDays specialDates specialDays
	_initRe: function(p){
		var i, v = $dp[p], re = "(?:";
		if (v) {
			for (i = 0; i < v.length; i++) {
				re += this.doExp(v[i]);
				if (i != v.length - 1) 
					re += "|";
			}
			re = new RegExp(re + ")");
		}
		else {
			re = null;
		}
		return re;
	},
	
	update: function(){
		var v = this.getNewDateStr();
		if ($dp.el[$dp.elProp] != v) 
			$dp.el[$dp.elProp] = v;
		this.setRealValue();
	},
	
	setRealValue: function(v) {
		var vel = $dp.$($dp.vel),v = rtn(v,this.getNewDateStr($dp.realFmt));
		if(vel){
			vel.value = v;
		}
		$dp.el['realValue']=v;		
	},
	
	doExp: function(s) {
        var ps = 'yMdHms', arr, tmpEval, re = /#?\{(.*?)\}/; //创建正则表达式模式。 匹配 { 表达式 }		
        s = s + '';
		for (var i = 0; i < ps.length; i++) {
            s = s.replace('%' + ps.charAt(i), this.getP(ps.charAt(i), null, $tdt));
        }
		
		if (s.substring(0, 3) == "#F{") {
			s = s.substring(3, s.length - 1);
			if (s.indexOf('return ') < 0) {
				s = 'return ' + s;
			}
			s = $dp.win.eval("new Function(\"" + s + "\");");
			s = s();
		}
		else {
			//var i = 0;
			while ((arr = re.exec(s)) != null) {
				arr.lastIndex = arr.index + arr[1].length + arr[0].length - arr[1].length - 1;
				tmpEval = pInt(eval(arr[1]));
				if (tmpEval < 0) {
					tmpEval = '9700' + (-tmpEval);
				}
				s = s.substring(0, arr.index) + tmpEval + s.substring(arr.lastIndex + 1);
			}
		}
		
		return s;
	},
	
	doCustomDate: function(s, fmt, defV) {
		var dt;
		
		s = this.doExp(s);
		
		if (!s || s == '') {

			s = defV;
		}
		
		if (typeof s == 'object') {			
			dt = s;
		}
		else {
			dt = this.splitDate(s, fmt, null, null, 1, 0, 0, 0, true);
			
			dt.y = ('' + dt.y).replace(/^9700/, '-');
			dt.M = ('' + dt.M).replace(/^9700/, '-');
			dt.d = ('' + dt.d).replace(/^9700/, '-');
			dt.H = ('' + dt.H).replace(/^9700/, '-');
			dt.m = ('' + dt.m).replace(/^9700/, '-');
			dt.s = ('' + dt.s).replace(/^9700/, '-');
			
			if (s.indexOf('%ld') >= 0) {
				s = s.replace(/%ld/g, '0');
				dt.d = 0;
				dt.M = pInt(dt.M) + 1;
			}
			dt.refresh();
		}
		//alert(dt.y + ' ' + dt.M + ' ' + dt.d + ' ' + dt.H + ' ' + dt.m + ' ' + dt.s);
		return dt;
	},
	
	//载入日期
	loadDate: function(){
		var v, f;
		
		if($dp.alwaysUseStartDate || ($dp.startDate != '' && $dp.el[$dp.elProp] == '')){
			v = this.doExp($dp.startDate);
            f = $dp.realFmt;
		}
		else {
			v = $dp.el[$dp.elProp];
            f = this.dateFmt;
		}
		$dt.loadFromDate(this.splitDate(v, f));
		
		if (v != '') {
			var rv = 1;
			if ($dp.has.sd && !this.isDate($dt)) {
				$dt.y = $tdt.y;
				$dt.M = $tdt.M;
				$dt.d = $tdt.d;
				rv = 0;
			}
			if ($dp.has.st && !this.isTime($dt)) {
				$dt.H = $tdt.H;
				$dt.m = $tdt.m;
				$dt.s = $tdt.s;
				rv = 0;
			}
			return  rv && this.checkValid($dt);
		}
		//v==''
		return 1;
	},
	
	isDate: function(dt){
		//把$dp.Date对象变成字符串
		if (dt.y != null) {
			dt = doStr(dt.y,4) + '-' + dt.M + '-' + dt.d;
		}
		return dt.match(/^((\d{2}(([02468][048])|([13579][26]))[\-\/\s]?((((0?[13578])|(1[02]))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\-\/\s]?((0?[1-9])|([1-2][0-9])))))|(\d{2}(([02468][1235679])|([13579][01345789]))[\-\/\s]?((((0?[13578])|(1[02]))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\-\/\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\-\/\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\s(((0?[0-9])|([1-2][0-3]))\:([0-5]?[0-9])((\s)|(\:([0-5]?[0-9])))))?$/);
	},
	
	isTime: function(d){
		if (d.H != null) {
			d = d.H + ':' + d.m + ':' + d.s;
		}
		return d.match(/^([0-9]|([0-1][0-9])|([2][0-3])):([0-9]|([0-5][0-9])):([0-9]|([0-5][0-9]))$/);
	},
	
	checkRange: function(dt, p){
		dt = dt || $dt;
		
		var v = dt.compareWith(this.minDate, p);
		if (v > 0) {
			v = dt.compareWith(this.maxDate, p);
			if (v < 0) {
				v = 0;
			}
		}
		return v;
	},
	checkValid: function(dt, p, k){
		p = p || $dp.has.minUnit;
		var v = this.checkRange(dt, p);
		if (v == 0) {
			v = 1;
			if (p == 'd' && k == null) {
				//考虑firstDayOfWeek的情况
				k = Math.abs((new Date(dt.y, dt.M - 1, dt.d).getDay() - $dp.firstDayOfWeek) % 7);
			}
			v = !this.testDisDay(k) && !this.testDisDate(dt, p);			
		}
		else {
			v = 0;
		}
		
		return v;
	},
	checkAndUpdate: function(){
		var el = $dp.el, c = this, v = $dp.el[$dp.elProp];
		if (v != null) {
			if (v != '') {
				c.date.loadFromDate(c.splitDate(v, c.dateFmt));
			}
			if (v == '' || (c.isDate(c.date) && c.isTime(c.date) && c.checkValid(c.date))) {
				if (v != '') {
					c.newdate.loadFromDate(c.date);
					c.update();
				}
				else {
					//空值时清空REALVALUE属性
					c.setRealValue('');
				}
			}
			else {
				return false;
			}
		}
		
		return true;
	},
	//验证并关闭
	close: function(e){
		hideSel();
		
		if (this.checkAndUpdate()) {
			this.mark(true);
			
			$dp.hide();		
		}
		else {
			if (e) {
				_cancelKey(e);
				this.mark(false, 2);
			}
			else {
				//标记错误
				this.mark(false);
			}
			$dp.show();
		}
	},
	_fd: function(){
        var i, j, k, isShow,firstDate,s = new sb(),wkStr=$lang.aWeekStr,firstDay=$dp.firstDayOfWeek;
        var classStr = '', classOnStr = '', dt = new DPDate($dt.y, $dt.M, $dt.d, 0, 0, 0);
        var y = dt.y, M = dt.M;
		
		firstDate = 1 - new Date(y, M - 1, 1).getDay() + firstDay;

		if(firstDate>1) firstDate-=7;
		
		//Table
		s.a('<table class=WdayTable width=100% border=0 cellspacing=0 cellpadding=0>');
		//Title
		s.a('<tr class=MTitle align=center>');
				
		//添加周
		if($dp.isShowWeek) s.a('<td>' + wkStr[0] + '</td>');
		
		for (i = 0; i < 7; i++) {
			s.a('<td>' + wkStr[(firstDay + i) % 7 + 1] + '</td>');
		}
		s.a('</tr>');
		//Day
		for (i = 1, j = firstDate; i < 7; i++) {
			s.a("<tr>");			
			for (k = 0; k < 7; k++) {
				dt.loadDate(y, M, j++);
				dt.refresh();
				
				if (dt.M == M) {
					isShow = true;
			
					if (dt.compareWith($sdt,'d')==0) {
					
						classStr = 'Wselday';
					}
					else {
						if (dt.compareWith($tdt,'d')==0) {
							//今天
							classStr = 'Wtoday';
						}
						else {
							classStr = ($dp.highLineWeekDay && (0 == (firstDay + k) % 7 || 6 == (firstDay + k) % 7) ? 'Wwday' : 'Wday');
						}
					}
					classOnStr = ($dp.highLineWeekDay && (0 == (firstDay + k) % 7 || 6 == (firstDay + k) % 7) ? 'WwdayOn' : 'WdayOn');
				}
				else {
					if ($dp.isShowOthers) {
						isShow = true;
						classStr = 'WotherDay';
						classOnStr = 'WotherDayOn';
					}
					else {
						isShow = false;						
					}
				}
				if ($dp.isShowWeek && k == 0 && (i < 4 || isShow)) {
					s.a('<td class=Wweek>' + getWeek(dt, $dp.firstDayOfWeek == 0 ? 1 : 0) + '</td>');
				}
				
				s.a("<td ");
				if (isShow) {
					if (this.checkValid(dt, 'd', k)) {	
						if(this.testSpeDay(Math.abs((new Date(dt.y, dt.M - 1, dt.d).getDay() - $dp.firstDayOfWeek) % 7)) || this.testSpeDate(dt)){
							classStr = 'WspecialDay';
						}				
							
						s.a('onclick="day_Click(' + dt.y + ',' + dt.M + ',' + dt.d + ');" ');
						s.a("onmouseover=\"this.className='" + classOnStr + "'\" ");
						s.a("onmouseout=\"this.className='" + classStr + "'\" ");						
					}
					else {
						classStr = 'WinvalidDay';
					}
					s.a("class=" + classStr);
					s.a(">" + dt.d + "</td>");
				}
				else {
					s.a("></td>");
				}
			}
			s.a("</tr>");
		}		
		s.a('</table>');
		return s.j();		
	},
	//测试无效日期
	testDisDate: function(d, p){
		var v = this.testDate(d, this.ddateRe, p);
		return (this.ddateRe && $dp.opposite) ? !v : v;
	},
	//测试无效天
	testDisDay: function(d){
		return this.testDay(d, this.ddayRe); 
	},
	//测试特殊日期
	testSpeDate: function(d){
		return this.testDate(d, this.sdateRe);
	},
	//测试特殊天
	testSpeDay: function(d){
		return this.testDay(d, this.sdayRe);
	},
	//d=日期
	//re=正则
	testDate: function(d, re, p){
		var fmt = p == 'd' ? $dp.realDateFmt : $dp.realFmt;
		return re ? re.test(this.getDateStr(fmt, d)) : 0;
	},	
	testDay: function(k, re){
		return re ? re.test(k) : 0;
	},
	
	_f: function(p, c, r, e, isR){		
		var s = new sb(), fp = isR ? 'r' + p : p;
		//备份
		bak = $dt[p];
		
		s.a("<table cellspacing=0 cellpadding=3 border=0");
		for (var i = 0; i < r; i++) {
			s.a("<tr nowrap=\"nowrap\">");
			for (var j = 0; j < c; j++) {
				s.a("<td nowrap ");
				$dt[p] = eval(e);
				if (($dp.opposite && this.checkRange($dt, p)==0) || this.checkValid($dt, p)) {
					s.a("class='menu' onmouseover=\"this.className='menuOn'\" onmouseout=\"this.className='menu'\" onmousedown=\"");
					//s.a("hide($d." + p + "D);c('" + p + "'," + $dt[p] + ");$d." + p + "I.blur()\"");
					s.a("hide($d." + p + "D);$d." + fp + "I.value=" + $dt[p] + ";$d." + fp + "I.blur();\"");
					
				}
				else {
					s.a("class='invalidMenu'");
				}
				s.a(">" + (p == 'M' ? $lang.aMonStr[$dt[p] - 1] : $dt[p]) + "</td>");
			}
			s.a("</tr>");
		}
		s.a("</table>");
		
		$dt[p] = bak;
		
		return s.j();
	},
	
	_fMyPos: function(el, div){
		if (el) {
			var left = el.offsetLeft;
			if ($IE) 
				left = el.getBoundingClientRect().left;
			
			div.style.left = left;
		}	
	},
	
	//填充月份
	_fM: function(el){
		this._fMyPos(el, $d.MD);
		$d.MD.innerHTML = this._f('M', 2, 6, 'i+j*6+1', el == $d.rMI);
	},	
		
	_fy: function(el,minV){		
		var s = new sb();
		minV = rtn(minV , $dt.y - 5);
		
		s.a(this._f('y', 2, 5, minV + '+i+j*5',el == $d.ryI));
		
		s.a("<table cellspacing=0 cellpadding=3 border=0 align=center><tr><td ");
		s.a(this.minDate.y < minV ? "class='menu' onmouseover=\"this.className='menuOn'\" onmouseout=\"this.className='menu'\" onmousedown='if(event.preventDefault)event.preventDefault();event.cancelBubble=true;$c._fy(0," + (minV - 10) + ")'" : "class='invalidMenu'");
		s.a(">←</td><td class='menu' onmouseover=\"this.className='menuOn'\" onmouseout=\"this.className='menu'\" onmousedown=\"hide($d.yD);$d.yI.blur();\">×</td><td ");
		s.a(this.maxDate.y > minV + 10 ? "class='menu' onmouseover=\"this.className='menuOn'\" onmouseout=\"this.className='menu'\" onmousedown='if(event.preventDefault)event.preventDefault();event.cancelBubble=true;$c._fy(0," + (minV + 10) + ")'" : "class='invalidMenu'");
		s.a(">→</td></tr></table>");
				
		this._fMyPos(el,$d.yD);
		$d.yD.innerHTML = s.j();
	},
		
	_fHMS: function(p, r, e){
		$d[p + 'D'].innerHTML = this._f(p, 6, r, e);
	},
	
	_fH: function(){
		this._fHMS('H', 4, 'i * 6 + j');
	},
	
	_fm: function(){
		this._fHMS('m', 2, 'i * 30 + j * 5');
	},
	
	_fs: function(){
		this._fHMS('s', 1, 'j * 10');
	},
	
	_fillQS: function(bFlat){
		this.initQS();
		var qs = this.QS, qss = qs.style,s = new sb();
		s.a('<table class=WdayTable width=100% height=100% border=0 cellspacing=0 cellpadding=0>');
		s.a('<tr class=MTitle><td><div style="float:left">' + $lang.quickStr + '</div>');
		if (!bFlat) {
			s.a('<div style="float:right;cursor:pointer" onclick="hide($d.qsDivSel);">×</div>')
		}
		s.a('</td></tr>');
		for (var i = 0; i < qs.length; i++) {
			if (qs[i]) {			
				s.a("<tr><td style='text-align:left' nowrap='nowrap' class='menu' onmouseover=\"this.className='menuOn'\" onmouseout=\"this.className='menu'\" onclick=\"");
				s.a("day_Click(" + qs[i].y + ", " + qs[i].M + ", " + qs[i].d + "," + qs[i].H + "," + qs[i].m + "," + qs[i].s + ");\">");
				s.a("&nbsp;" + this.getDateStr(null, qs[i]));
				s.a('</td></tr>');
			}
			else {
				s.a("<tr><td class='menu'>&nbsp;</td></tr>");
			}
		}
		s.a("</table>");
		$d.qsDivSel.innerHTML = s.j();
	},
	
	_dealFmt: function(){		
		_setHas(/w/);		
		_setHas(/WW|W/);
		_setHas(/DD|D/);
		_setHas(/yyyy|yyy|yy|y/);
		_setHas(/MMMM|MMM|MM|M/);
		_setHas(/dd|d/);
		_setHas(/HH|H/);
		_setHas(/mm|m/);
		_setHas(/ss|s/);
		$dp.has.sd = ($dp.has.y || $dp.has.M || $dp.has.d) ? true : false;
		$dp.has.st = ($dp.has.H || $dp.has.m || $dp.has.s) ? true : false;
		
		//创建realFullFmt
		$dp.realFullFmt = $dp.realFullFmt.replace(/%Date/,$dp.realDateFmt).replace(/%Time/,$dp.realTimeFmt);
		//创建realFmt
		if ($dp.has.sd) {
			if ($dp.has.st) {
				$dp.realFmt = $dp.realFullFmt;
			}
			else {
				$dp.realFmt = $dp.realDateFmt;
			}
		}
		else {
			$dp.realFmt = $dp.realTimeFmt;
		}
		
		function _setHas(re){
			var p = (re+'').slice(1,2);
			$dp.has[p] = re.exec($dp.dateFmt) ? ($dp.has.minUnit = p, true) : false;
		}
	},
	
	initShowAndHide: function(){
		var hasYorM = 0;		
		
		$dp.has.y?(hasYorM = 1,show($d.yI, $d.navLeftImg, $d.navRightImg)):hide($d.yI, $d.navLeftImg, $d.navRightImg);
		
		$dp.has.M?(hasYorM = 1,show($d.MI, $d.leftImg, $d.rightImg)):hide($d.MI, $d.leftImg, $d.rightImg);
			
		hasYorM ? show($d.titleDiv) : hide($d.titleDiv);
		
		if ($dp.has.st) {
			show($d.tDiv);
			disHMS($d.HI, $dp.has.H);
			disHMS($d.mI, $dp.has.m);
			disHMS($d.sI, $dp.has.s);
		}
		else {
			hide($d.tDiv);
		}
		shorH($d.clearI, $dp.isShowClear);
		shorH($d.todayI, $dp.isShowToday);		
		shorH($d.okI, $dp.isShowOK);
				
		shorH($d.qsDiv, !$dp.doubleCalendar && $dp.has.d && $dp.qsEnabled);
		
		if ($dp.eCont || !($dp.isShowClear || $dp.isShowToday || $dp.isShowOK)) {
			hide($d.bDiv);
		}
		else{
			show($d.bDiv);
		}
	},
	
	mark: function(b,mode){
		var el = $dp.el;
		var cls = $FF ? 'class' : 'className';
		if (b) {
			_unmark(el);
		}
		else {
			if(mode == null)
			  mode = $dp.errDealMode;
			switch (mode) {
				case 0://提示			
					if (confirm($lang.errAlertMsg)) {
						el[$dp.elProp] = this.oldValue;
						_unmark(el);
					}
					else {
						_mark(el);
					}
					break;
				case 1://自动纠正
					el[$dp.elProp] = this.oldValue;
					_unmark(el);
					break;
				case 2://标记
					_mark(el);
					break;
			}
		}
		
		function _unmark(el){
			var cn = el.className;
			if (cn) {
				var s = cn.replace(/WdateFmtErr/g, '');
				if (cn != s) {
					//FF中要使用setAttribute才有效
					el.setAttribute(cls,s);
					//el[cls]=s;
				}
			}					
		}
		function _mark(el){
			//FF中要使用setAttribute才有效
			el.setAttribute(cls,el.className + ' WdateFmtErr');
		}
	},
	
	getP: function(p, f, dt){
		dt = dt || $sdt;
		var i, r = [p + p, p], ri, v = dt[p];
		var getV = function(ri){
			return doStr(v, ri.length);
		};
		switch (p) {
			case 'w'://星期
				v = getDay(dt);
				break;
			case 'D'://星期 D:短  DD:长
				var tempD=getDay(dt) + 1;
				getV = function(ri){
					return ri.length == 2 ? $lang.aLongWeekStr[tempD] : $lang.aWeekStr[tempD];
				};
				break;
			case 'W'://周
				v = getWeek(dt);
				break;
			case 'y':
				r = ['yyyy', 'yyy', 'yy', 'y'];
				f = f || r[0];
				getV = function(ri){
					return doStr((ri.length < 4) ? (ri.length < 3 ? dt.y % 100 : (dt.y + 2000 - $dp.yearOffset) % 1000) : v, ri.length);
				};
				break;
			case 'M':
				r = ['MMMM', 'MMM', 'MM', 'M'];
				getV = function(ri){
					return (ri.length == 4) ? $lang.aLongMonStr[v-1] : (ri.length == 3) ? $lang.aMonStr[v-1] : doStr(v,ri.length);
				};
				break;
		}
		f = f || p + p;
		
		if ('yMdHms'.indexOf(p) > -1 && p != 'y' && !$dp.has[p]) {
			if ('Hms'.indexOf(p) > -1) 
				v = 0;
			else 
				v = 1;
		}
						
		var values = [];
		for (i = 0; i < r.length; i++) {
			ri = r[i];
			if (f.indexOf(ri) >= 0) {
				//f = f.replace(ri, getV(ri));
				
				values[i] = getV(ri);
				f = f.replace(ri, '{' + i + '}');
			}
		}
		
		for (i = 0; i < values.length; i++) {
			f = f.replace(new RegExp('\\{' + i + '\\}','g'), values[i]);
		}
		return f;
	},
	getDateStr: function(f, dt){		
		dt = dt || this.splitDate($dp.el[$dp.elProp],this.dateFmt) || $sdt;
		f = f || this.dateFmt;
	
		//处理f中的%ld
		
		if (f.indexOf('%ld') >= 0) {
			var tmpDT = new DPDate();
			tmpDT.loadFromDate(dt);
			tmpDT.d = 0;
			tmpDT.M = pInt(tmpDT.M) + 1;
			tmpDT.refresh();
			f = f.replace(/%ld/g, tmpDT.d);
		}
				
		var s = 'ydHmswW';  
		for (var i = 0; i < s.length; i++) {
			var p = s.charAt(i);
			f = this.getP(p, f, dt);
		}
		if ($dp.has['D']) {
			f = f.replace(/DD/g, '%dd').replace(/D/g, '%d');

			f = this.getP('M', f, dt);

			f = f.replace(/\%dd/g, this.getP('D', 'DD')).replace(/\%d/g, this.getP('D', 'D'));
		}
		else
			f = this.getP('M', f, dt);				
			
		return f;
	},	
	getNewP: function(p, f){
		return this.getP(p, f, $dt);
	},
	getNewDateStr: function(f){
		return this.getDateStr(f, $dt);
	},
		
	draw: function(){
		$d.rMD.innerHTML = '';
		if ($dp.doubleCalendar) {
			//autopickdate置为true
			$c.autoPickDate=true;
			$dp.isShowOthers=false;
			//双月显示			
			$d.className = 'WdateDiv WdateDiv2';
			//if(pInt2(getStyle($d,'width'),0)>0) $d.style.width=pInt2(getStyle($d,'width'),0)*2;
			var s = new sb();
			s.a("<table class=WdayTable2 width=100% cellspacing=0 cellpadding=0 border=1><tr><td valign=top>");
			s.a(this._fd());
			s.a("</td><td valign=top>");
			//月份+1
			$dt.attr('M', 1);
			//产生天
			s.a(this._fd());
			
			$d.rMI = $d.MI.cloneNode(true);
			$d.ryI = $d.yI.cloneNode(true);
			
			$d.rMD.appendChild($d.rMI);
			$d.rMD.appendChild($d.ryI);
			
			$d.rMI.value = $lang.aMonStr[$dt.M - 1];
			$d.rMI["realValue"]=$dt.M;
			
			$d.ryI.value = $dt.y;
			//添加事件
			_inputBindEvent('rM,ry');
			$d.rMI.className = $d.ryI.className = 'yminput';
			
			//日期还原
			$dt.attr('M', -1);
			
			s.a("</td></tr></table>");
			$d.dDiv.innerHTML = s.j();
		}
		else {
			//单月
			$d.className = 'WdateDiv';
			$d.dDiv.innerHTML = this._fd();
		}
		
		if (!$dp.has.d || $dp.autoShowQS) {
			this._fillQS(true);
			showB($d.qsDivSel);
		}
		else {
			hide($d.qsDivSel);
		}
		
		this.autoSize();
	},
	autoSize: function(){
		var ifs = parent.document.getElementsByTagName('iframe');
		for (var i = 0; i < ifs.length; i++) {
			var bh = $d.style.height;
			$d.style.height = '';
			var h = $d.offsetHeight;
			
			if (ifs[i].contentWindow == window && h) {
				ifs[i].style.width = $d.offsetWidth + "px";
				
				var th = $d.tDiv.offsetHeight;	
					
				if (th && $d.bDiv.style.display == 'none' && $d.tDiv.style.display != 'none' && document.body.scrollHeight - h >= th) {
					h += th;
					$d.style.height = h;
				}
				else 
					$d.style.height = bh;
				
				//alert(document.body.scrollHeight + ' ' + $d.offsetHeight + ' ' + h)
				
				ifs[i].style.height = Math.max(h,$d.offsetHeight) + "px";								
			}
		}
				
		$d.qsDivSel.style.width = $d.dDiv.offsetWidth;
		$d.qsDivSel.style.height = $d.dDiv.offsetHeight;
	},
	
	pickDate: function(){

        $dt.d = Math.min(new Date($dt.y, $dt.M, 0).getDate(), $dt.d);
		$sdt.loadFromDate($dt);
		
        this.update();
		
        if (!$dp.eCont) {
            if (this.checkValid($dt)) {

				elFocus();
				
				hide($dp.dd);
			}
			//else {
			//	$c.mark(false);
			//}
        }
    
        if ($dp.onpicked) {
            callFunc('onpicked');
        }
		
	},
	
	//设置操作按钮
	initBtn: function(){
		//按钮事件
		$d.clearI.onclick = function(){
			//清空事件
			if (!callFunc('onclearing')) {
				$dp.el[$dp.elProp] = '';
                $c.setRealValue('');

				elFocus();
				
				hide($dp.dd);
				
				if ($dp.oncleared) {
					callFunc('oncleared');
				}
		
			}
		};
		
		$d.okI.onclick = function(){
			day_Click();
		};
				
		
		if (this.checkValid($tdt)) {
			$d.todayI.disabled = false;
			$d.todayI.onclick = function(){
				$dt.loadFromDate($tdt);
				day_Click();
			};
		}
		else {
			$d.todayI.disabled = true;
		}
	},
	
	initQS: function(){
		var i, j, d, rv, arr = [], total = 5, l = $dp.quickSel.length, u = $dp.has.minUnit;
		
		if (l > total) {
			l = total;
		}
		else {
			//产生数组
			if (u == 'm' || u == 's') {
				arr = [-60, -30, 0, 30, 60, -15, 15, -45, 45];
			}
			else {
				for (i = 0; i < total; i++) {
					arr[i] = $dt[u] - 2 + i;
				}
			}			
		}
		for (i = j = 0; i < l; i++) {
			d = this.doCustomDate($dp.quickSel[i]);
			if(this.checkValid(d)){
				this.QS[j++] = d;
			}
		}
		
		var s = "yMdHms", tmpArr = [1, 1, 1, 0, 0, 0];
        for (i = 0; i <= s.indexOf(u); i++) {
            tmpArr[i] = $dt[s.charAt(i)];
        }
		
		for (i = 0; j < total; i++) {			
			if (i < arr.length) {
				d = new DPDate(tmpArr[0], tmpArr[1], tmpArr[2], tmpArr[3], tmpArr[4], tmpArr[5]);
				d[u] = arr[i];
				d.refresh();
				if (this.checkValid(d)) {
					this.QS[j++] = d;
				}
			}
			else {
				this.QS[j++] = null;
			}	
		}
	}
}

function elFocus(){
	var el = $dp.el;
	try{
		if(el.style.display != 'none' && el.type!='hidden' && (el.nodeName.toLowerCase()=='input' || el.nodeName.toLowerCase()=='textarea')){
			if($dp.srcEl == el) $dp.el["My97Mark"] = true;
			$dp.el.focus();
			return;
		}
	}
	catch(e){}
	el["My97Mark"] = false;
}

function sb(){
    this.s = new Array();
    this.i = 0;
    this.a = function(t){
        this.s[this.i++] = t;
    };
    this.j = function(){
        return this.s.join('');
    };
}

function getWeek(dt, offset){	
	offset = offset || 0;
	var d = new Date(dt.y, dt.M - 1, dt.d + offset);
	d.setDate(d.getDate() - (d.getDay() + 6) % 7 + $dp.whichDayIsfirstWeek - 1); // Nearest Thu
	var ms = d.valueOf(); // GMT
	d.setMonth(0);
	d.setDate(4); // Thu in Week 1
	return Math.round((ms - d.valueOf()) / (7 * 864e5)) + 1;

}

function getDay(dt){
	var d = new Date(dt.y, dt.M - 1, dt.d);
	return d.getDay();
}

function show(){
    setDisp(arguments, '');
}

function showB(){
    setDisp(arguments, 'block');
}

function hide(){
    setDisp(arguments, 'none');
}

function setDisp(args, v){
	for (i = 0; i < args.length; i++) {
		args[i].style.display = v;
	}
}
//show or hide
function shorH(el, bExp){
	bExp ? show(el) : hide(el);
}

function disHMS(el, bExp){
    if (bExp) {
        el.disabled = false;
    }
    else {
        el.disabled = true;
        el.value = "00";
    }
}

//更新值 y M d H m s
function c(p, pv){
	if (p == 'M') {
		pv = makeInRange(pv, 1, 12);
	}
	else 
		if (p == 'H') {
			pv = makeInRange(pv, 0, 23);
		}
		else 
			if ('ms'.indexOf(p) >= 0) {
				pv = makeInRange(pv, 0, 59);
			}
		
	if ($sdt[p] != pv && !callFunc(p + 'changing')) {
		//设置值
		var func = 'sv("' + p + '",' + pv + ')', rv = $c.checkRange();
		if (rv == 0) {
			eval(func);
		}
		else 
			if (rv < 0) {				
				_setFrom($c.minDate);
			}
			else 
				if (rv > 0) {
					_setFrom($c.maxDate);
				}
				
		$d.okI.disabled = !$c.checkValid($sdt);
		
		if ('yMd'.indexOf(p) >= 0) 
			$c.draw();
		
		callFunc(p + 'changed');				
	}
	
	function _setFrom(dt){
		_setAll($c.checkValid(dt) ? dt : $sdt);
	}
}

function _setAll(o){
	sv('y', o.y);
	sv('M', o.M);
	sv('d', o.d);
	sv('H', o.H);
	sv('m', o.m);
	sv('s', o.s);
}

//日期的单击事件
function day_Click(y, M, d, H, m, s){
	var bak = new DPDate($dt.y, $dt.M, $dt.d, $dt.H, $dt.m, $dt.s);
	$dt.loadDate(y, M, d, H, m, s);
	
	//执行选中日期前的事件
	if (!callFunc('onpicking')) {
		var isCurrDay = bak.y == y && bak.M == M && bak.d == d;
		if (!isCurrDay && arguments.length != 0) {    
			c('y', y);
			c('M', M);
			//改变日期
			c('d', d);
			//设置焦点
			$c.currFocus = $dp.el;
			
			//是否自动更新
			if ($dp.autoUpdateOnChanged) {
				$c.update();
			}
		}
		
		if ($c.autoPickDate || isCurrDay || arguments.length == 0) {
			$c.pickDate();
		}
	}
	else {
		$dt = bak;
	}
}

function callFunc(eventName){		
	var rv;
	if ($dp[eventName]) 
		rv = $dp[eventName].call($dp.el, $dp);
	return rv;
}

//设置值
function sv(p,v){
	if(v == null)
		v = $dt[p];
	$sdt[p] = $dt[p] = v;
	if ('yHms'.indexOf(p) >= 0) {
		$d[p + 'I'].value = v;
	}
	if(p=='M'){
		$d.MI["realValue"]=v;
    	$d.MI.value = $lang.aMonStr[v - 1];
	}	
}

function makeInRange(v, min, max){
	if (v < min) {
		v = min;
	}
	else if (v > max) {
		v = max;
	}
	return v;
}
	
function attachTabEvent(o, func){
	o.attachEvent('onkeydown', function(){
		var e = event, k = (e.which == undefined) ? e.keyCode : e.which;
		//按tab键 
		if (k == 9) {
			func();
		}
	});
}

function doStr(s, len){
	s = s + '';
	while (s.length < len) {
		s = '0' + s;
	}
	return s;
}
		
function hideSel(){
	hide($d.yD, $d.MD, $d.HD, $d.mD, $d.sD);
}

function updownEvent(offset){
	if ($c.currFocus == undefined) {
		$c.currFocus = $d.HI;
	}
	switch ($c.currFocus) {
		case $d.HI:
			c('H',$dt.H + offset);
			break;
		case $d.mI:
			c('m',$dt.m + offset);
			break;
		case $d.sI:
			c('s',$dt.s + offset);
			break;
	}
	
	//是否自动更新
	if ($dp.autoUpdateOnChanged) {
		$c.update();
	}
}

function DPDate(y, M, d, H, m, s){
	this.loadDate(y, M, d, H, m, s);
}

DPDate.prototype = {
	loadDate:function(y, M, d, H, m, s){
		var dt = new Date();
		this.y = pInt3(y, this.y, dt.getFullYear());
		this.M = pInt3(M, this.M, dt.getMonth() + 1);
		this.d = $dp.has.d ? pInt3(d, this.d, dt.getDate()) : 1;
		this.H = pInt3(H, this.H, dt.getHours());
		this.m = pInt3(m, this.m, dt.getMinutes());
		this.s = pInt3(s, this.s, dt.getSeconds());
	},
	loadFromDate: function(o){
		if(o)
			this.loadDate(o.y, o.M, o.d, o.H, o.m, o.s);
	},
	coverDate: function(y, M, d, H, m, s){
		var dt = new Date();
		this.y = pInt3(this.y, y, dt.getFullYear());
		this.M = pInt3(this.M, M, dt.getMonth() + 1);
		this.d = $dp.has.d ? pInt3(this.d, d, dt.getDate()) : 1;
		this.H = pInt3(this.H, H, dt.getHours());
		this.m = pInt3(this.m, m, dt.getMinutes());
		this.s = pInt3(this.s, s, dt.getSeconds());
	},
	//p = yMdHms
	compareWith: function(dt, p){
		var s = 'yMdHms', v, tp;
		p = s.indexOf(p);
		p = p >= 0 ? p : 5;
		for (var i = 0; i <= p; i++) {
			tp = s.charAt(i);
			v = this[tp] - dt[tp];
			if (v > 0) {
				return 1;
			}
			else 
				if (v < 0) {
					return -1;
				}
		}
		return 0;
	},
	refresh: function(){
		var dt = new Date(this.y, this.M - 1, this.d, this.H, this.m, this.s);
		this.y = dt.getFullYear();
		this.M = dt.getMonth() + 1;
		this.d = dt.getDate();
		this.H = dt.getHours();
		this.m = dt.getMinutes();
		this.s = dt.getSeconds();
		return !isNaN(this.y);
	},
	//p = yMdHms
	//对年月日时分秒进行加减
	attr: function(p,v){		
		if ('yMdHms'.indexOf(p) >= 0) {
			var pback = this.d;
			
			if (p == 'M') 
				this.d = 1;
			
			this[p] += v;
			this.refresh();
			//还原
			this.d = pback;
		}
	}
};

function pInt(n){
    return parseInt(n, 10);
}

//当参数为非数字时,返回的默认值
function pInt2(v1, v2){
	return rtn(pInt(v1), v2);
}

function pInt3(v1, v2, v3){
	return pInt2(v1, rtn(v2, v3));
}

function rtn(v1, v2){
	return v1 == null || isNaN(v1) ? v2 : v1;
}

function fireEvent(o, evtName){
	if ($IE) {
		o.fireEvent('on' + evtName);
	}
	else {
		var evt = document.createEvent('HTMLEvents');
		evt.initEvent(evtName, true, true);
		o.dispatchEvent(evt);
	}
}

function _foundInput(el){
	var p,i,arr = 'y,M,H,m,s,ry,rM'.split(',');
	for (i = 0; i < arr.length; i++) {
		p = arr[i];
		if ($d[p + 'I'] == el) {
			return p.slice(p.length - 1, p.length);
		}
	}
	return 0;
}

//所有input的focus事件
function _focus(e){	
	var p = _foundInput(this);
	if(!p) return;
	$c.currFocus = this;
	if (p == 'y') {
		this.className = 'yminputfocus';
	}
	else if (p == 'M') {
		this.className = 'yminputfocus';
		this.value =this["realValue"];
	}
		
	this.select();
	$c['_f' + p](this);
	showB($d[p + 'D']);	
}

function _blur(showDiv){
	var p = _foundInput(this), isR, mStr, v = this.value, oldv = $dt[p];
	if(p==0) return;
	$dt[p] = Number(v)>=0?Number(v):$dt[p];
	
	if (p == 'y') {
		isR = this == $d.ryI;
		if (isR && $dt.M == 12) {
			$dt.y -= 1;
		}
	}
	else 
		if (p == 'M') {			
			isR = this == $d.rMI;
			if (isR) {				
				mStr = $lang.aMonStr[$dt[p] - 1];
				if (oldv == 12) 
					$dt.y += 1;
				
				$dt.attr('M', -1);
			}			
			if ($sdt.M == $dt.M) {
				this.value = mStr||$lang.aMonStr[$dt[p] - 1];
			}
			
			if(($sdt.y != $dt.y))
				c('y', $dt.y);			
		}
	
	eval('c("' + p + '",' + $dt[p] + ')');
	
	if (showDiv !== true) {
		if (p == 'y' || p == 'M') 
			this.className = 'yminput';
		hide($d[p + 'D']);
	}
	
	if ($dp.autoUpdateOnChanged) {
		$c.update();
	}
}

function _cancelKey(e){
	if (e.preventDefault) {
		e.preventDefault();
		e.stopPropagation();
	}
	else {
		e.cancelBubble = true;
		e.returnValue = false;
	}
	
	if ($OPERA) 
		e.keyCode = 0;
}

//str = y,M,H,m,s,ry,rM
function _inputBindEvent(str){
	var _arr = str.split(',');
	for (var i = 0; i < _arr.length; i++) {
		var _p = _arr[i] + 'I';
		$d[_p].onfocus = _focus;
		$d[_p].onblur = _blur;
		//$d[_p].attachEvent('onkeydown', _inputKeydown);
	}
}

//$dp.el 的keydown事件
function _tab(e){
	var curr = e.srcElement || e.target, k = e.which || e.keyCode
		isShow = $dp.dd.style.display != 'none';
		
	//小键盘的字符转换
	if(k >= 96 && k <= 105) k-= 48;
	
	//键盘控制开关
	if ($dp.enableKeyboard && isShow) {
		if (!curr.nextCtrl) {
			curr.nextCtrl = $dp.focusArr[1];
			$c.currFocus = $dp.el;
		}
		
		if (curr == $dp.el) {
			$c.currFocus = $dp.el;
		}
		
		//ESC
		if (k == 27) {
			if (curr == $dp.el) {
				$c.close();
				return;
			}
			else {
				
				$dp.el.focus();
			}
		}
		if (k >= 37 && k <= 40) {
			//37 <,39 >,38 ^,40 v
			
			var p;
			
			if ($c.currFocus == $dp.el || $c.currFocus == $d.okI) {
				if ($dp.has.d) {
					p = 'd';
					if (k == 38) 
						$dt[p] -= 7;
					else 
						if (k == 39) {
							$dt[p] += 1;
						}
						else 
							if (k == 37) {
								$dt[p] -= 1;
							}
							else 
								$dt[p] += 7;
					
					$dt.refresh();
					c('y', $dt['y']);
					c('M', $dt['M']);
					c('d', $dt[p]);
					
					_cancelKey(e);
					return;
				}
				else {
					p = $dp.has.minUnit;
					$d[p + 'I'].focus();
				}
			}
			
			p = p || _foundInput($c.currFocus);
			if (p) {
				//y M H m s
				if (k == 38 || k == 39) {
					$dt[p] += 1;
				}
				else {
					$dt[p] -= 1;
				}
				$dt.refresh();
				$c.currFocus.value = $dt[p];
				_blur.call($c.currFocus, true);
				$c.currFocus.select();
			}
			
		}
		else {					
			if (k == 9) {
				var next = curr.nextCtrl;
				
				for (var i = 0; i < $dp.focusArr.length; i++) {
					if (next.disabled == true || next.offsetHeight == 0) 
						next = next.nextCtrl;
					else 
						break;
				}
				
				if ($c.currFocus != next) {
					$c.currFocus = next;
					next.focus();
				}
			}
			//回车
			else 
				if (k == 13) {
					_blur.call($c.currFocus);
					
					if ($c.currFocus.type == 'button') 
						$c.currFocus.click();
					else 
						$c.pickDate();
					
					$c.currFocus = $dp.el;
				}
		}
	}
	else 
		if (k == 9 && curr == $dp.el) {
			$c.close();
		}
	
	if ($dp.enableInputMask && !$OPERA && !$dp.readOnly && $c.currFocus == $dp.el && (k >= 48 && k <= 57)) {		
		//如果在输入框里按键
		var el = $dp.el, v = el.value, 
			pos = getPosition(el), ss = {str:'',arr:[]}, //ss str数字串,arr对应位数数字串的前置字符是否为分隔符
			i = 0, mm, vStart = 0, vEnd = 0,n = 0,offset,
			tokenRe = /yyyy|yyy|yy|y|MM|M|dd|d|%ld|HH|H|mm|m|ss|s|WW|W|w/g, 
			g = $dp.dateFmt.match(tokenRe),t1,t2,t3,t4,t5,vlen,offset=0;
				
		//算出数字数量
		if (v != '') {
			n = v.match(/[0-9]/g);
            n = n == null ? 0 : n.length;
			
			for (i = 0; i < g.length; i++) {
				n -= Math.max(g[i].length, 2);
			}
			n = n >= 0 ? 1: 0;
			if(n == 1 && pos >= v.length) pos = v.length - 1;
		}

		v = v.substring(0, pos) + String.fromCharCode(k) + v.substring(pos + n);
		pos++;

		//ss = v.match(/[0-9]/g).join('');
		for (i = 0; i < v.length; i++) {
			var vi = v.charAt(i);
			if (/[0-9]/.test(vi)) 
				ss.str+= vi;
			else 
				//ss.arr[ss.str.length]=1;
				ss.arr[i]=1;
		}
		v = '';
		tokenRe.lastIndex = 0;
		while ((mm = tokenRe.exec($dp.dateFmt)) !== null) {
			//如果是 %ld 长度为2,所以 -1
            vEnd = mm.index - (mm[0] == '%ld' ? 1 : 0);
			
			if(vStart>=0){
				v += $dp.dateFmt.substring(vStart, vEnd);
				if (pos >= vStart+offset && pos <= vEnd+offset) 
					pos += vEnd - vStart;
			}
			vStart = tokenRe.lastIndex;
			vlen = 	vStart - vEnd;		
			t1 = ss.str.substring(0, vlen);
			t2 = mm[0].charAt(0);
            t3 = pInt(t1.charAt(0));
			if (ss.str.length > 1) {
				t4 = ss.str.charAt(1);
				t5 = t3*10+pInt(t4);
			}
			else{
				t4 = '';
				t5 = t3;
			}
			
            if (ss.arr[vEnd+1] || 
			t2 == 'M' && t5 > 12 ||
			t2 == 'd' && t5 > 31 ||
			t2 == 'H' && t5 > 23 ||
			'ms'.indexOf(t2) >= 0 && t5 > 59) {
				if(mm[0].length == 2 ){
					t1 = '0' + t3;
				}		
				else{
					t1 = t3;
				}
				pos++;
			}
			else if (vlen == 1) {
				t1 = t5;
				vlen++;
				offset++;
			}			
			
			v += t1;
				
			ss.str = ss.str.substring(vlen);
			
			if(ss.str=='') break;			
		}
		
		el.value = v;
		setPosition(el, pos);
		
		_cancelKey(e);
	}

	if (isShow && $c.currFocus != $dp.el && !((k >= 48 && k <= 57) || k == 8 || k == 46)) {
		_cancelKey(e);
	}
			
	function getPosition(ctrl){
		var CaretPos = 0; // IE Support
		if ($dp.win.document.selection) {
			//ctrl.focus();
			var sel = $dp.win.document.selection.createRange(), sellength=sel.text.length;
			sel.moveStart('character', -ctrl.value.length);
			CaretPos = sel.text.length - sellength;
		}
		else 
			if (ctrl.selectionStart || ctrl.selectionStart == '0') {
				// Firefox support
				CaretPos = ctrl.selectionStart;
			}
				
		return CaretPos;
	}
	function setPosition(ctrl, pos){
		if (ctrl.setSelectionRange) {
			ctrl.focus();
			ctrl.setSelectionRange(pos, pos);
		}
		else 
			if (ctrl.createTextRange) {
				var range = ctrl.createTextRange();
				range.collapse(true);
				range.moveEnd('character', pos);
				range.moveStart('character', pos);
				range.select();
			}
	}
}

