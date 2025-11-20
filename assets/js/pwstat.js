(function(){
	var u = document.location;
    var analyticsConfig = [
    	{
    		"url":"www.playperfectworld.com",
    		"id":"UA-146596505-2"
    	},
    	{
    		"url":"www.playperfectworld.co.kr",
    		"id":"UA-146596505-1"
    	},
        {
            "url":"ym.perfectworldgames.com",
            "id":"UA-146596505-4"
        },
        {
            "url":"www.playeveradventure.com",
            "id":"UA-146596505-5"
        },
        {
            "url":"www.playdkmobile.com",
            "id":"UA-146596505-6"
        },
        {
            "url":"www.playmegalegends.com",
            "id":"UA-146596505-7"
        },
		{
            "url":"www.perfectworldrevolution.com",
            "id":"G-JLCCHCCJ49"
        },
        {
            "url":"swordsman.games.wanmei.com",
            "id":"G-D3CW27WRNR"
        },
        {
            "url":"www.jadedynasty.games",
            "id":"G-9QN76LC58Q"
        },
		{
            "url":"sea.jadedynasty.games",
            "id":"G-DDZPV968MB"
        },
        {
            "url":"tof.pwrd.co.kr",
            "id":"G-2N675BXDH1"
        },
        {
            "url":"games.wanmei.com",
            "id":"G-8JYNCY9GNC"
        }
    ];
    var filterOptions = function () {
        var len = analyticsConfig.length;
        var ids = "";
        for (var i = 0; i < len; i++) {
            if (u.hostname == analyticsConfig[i].url){
                ids = analyticsConfig[i].id
            };
        };
        if(u.href.indexOf("www.playperfectworld.com/ru/") >= 0){
            ids = "UA-146596505-3"
        };
        return ids;
    };


    var googleID = filterOptions();
    if(googleID == "") {return};
    
    var loadJS = function (url, callback) {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = url;
        s.onload = s.onreadystatechange = function () {
            if (!this.readyState || 'loaded' === this.readyState || 'complete' === this.readyState) {
                s.onload = s.onreadystatechange = null;
                if (callback) callback();
                s.parentNode.removeChild(s);
            }
        };
        var doc = document.getElementsByTagName('head')[0];
        doc.appendChild(s);
    };

    var googleSrc = 'https://www.googletagmanager.com/gtag/js?id='+googleID;
    setTimeout(function () { loadJS(googleSrc,function(){
    	window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', googleID);
    })}, 10);


    // setTimeout(function(){loadJS("https://static.games.wanmei.com/public/js/tjsdk-min-1.7.1.js",function(){
    //     var myAnaly;
    //     myAnaly = new webSdk();
    //     //myAnaly.setDebug("true")
    //     myAnaly.initSDK({ project: "wmwebsite", linkHost: "https://clog.tanshudata.com",withAppJsBridge:false,updatelog:true});
    //     myAnaly.pageVisted();
    //     window.myAnaly = myAnaly;
    // })}, 10); 
})();

