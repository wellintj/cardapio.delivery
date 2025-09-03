
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js"></script>
<script>
		let isLocalhost = `<?= isLocalHost()==1?true:false;?>`
	   var OneSignal = window.OneSignal || [];
	    var initConfig = {
	        appId: `<?= $appID ;?>`,
	        notifyButton: {
	            enable: true
	        },
			allowLocalhostAsSecureOrigin: isLocalhost,
	    };
	    OneSignal.push(function () {
	        OneSignal.SERVICE_WORKER_PARAM = { scope: '/' };
	        OneSignal.SERVICE_WORKER_PATH = 'assets/push/OneSignalSDKWorker.js'
	        OneSignal.SERVICE_WORKER_UPDATER_PATH = 'assets/push/OneSignalSDKWorker.js'
	        OneSignal.init(initConfig);
	    });
	</script>
