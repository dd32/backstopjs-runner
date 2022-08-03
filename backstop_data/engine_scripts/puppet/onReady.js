module.exports = async (page, scenario, vp) => {
  console.log('SCENARIO > ' + scenario.label);
  await require('./clickAndHoverHelper')(page, scenario);


function waitForNetworkIdle(page, timeout, maxInflightRequests = 0) {
  page.on('request', onRequestStarted);
  page.on('requestfinished', onRequestFinished);
  page.on('requestfailed', onRequestFinished);

  let inflight = 0;
  let fulfill;
  let promise = new Promise(x => fulfill = x);
  let timeoutId = setTimeout(onTimeoutDone, timeout);
  return promise;

  function onTimeoutDone() {
    page.removeListener('request', onRequestStarted);
    page.removeListener('requestfinished', onRequestFinished);
    page.removeListener('requestfailed', onRequestFinished);
    fulfill();
  }

  function onRequestStarted() {
    ++inflight;
    if (inflight > maxInflightRequests)
      clearTimeout(timeoutId);
  }

  function onRequestFinished() {
    if (inflight === 0)
      return;
    --inflight;
    if (inflight === maxInflightRequests)
      timeoutId = setTimeout(onTimeoutDone, timeout);
  }
}

  // Make lazy-loaded images appear quicker.
  page.evaluate( async () => {
    document.querySelectorAll('[loading="lazy"]').forEach((elem) => {
      elem.loading = 'eager';
    });
  });

  // Wait for all fonts to load..
  await page.waitForFunction('"loaded" == document.fonts.status');

//  await page.waitForNetworkIdle( { idleTime: 10000 } );
  await waitForNetworkIdle( page, 15000);
  // Make JSON look prettier for better visual diffs.
  page.waitForFunction( function() {
    if ( document.body.innerText.startsWith( '{' ) ) {
      var json = JSON.stringify( JSON.parse( document.body.innerText ), null, 4 );
      document.body.innerHTML = '<pre style="white-space: pre-wrap;"></pre>';
      document.getElementsByTagName('pre')[0].innerText = json;
    }
    return true;
  } );
};
