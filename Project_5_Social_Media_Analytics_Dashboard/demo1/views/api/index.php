<?php require "views/layouts/header.php"; ?>
<h2>RESTful API</h2>
<div class="card mb-4"><div class="card-body">
  <h5>Available Endpoints</h5>
  <pre class="bg-light p-3 rounded">
GET index.php?controller=api&amp;action=data&amp;endpoint=metrics
GET index.php?controller=api&amp;action=data&amp;endpoint=metrics&amp;platform=instagram
GET index.php?controller=api&amp;action=data&amp;endpoint=posts
GET index.php?controller=api&amp;action=data&amp;endpoint=webhooks
  </pre>
  <div class="d-flex gap-2 flex-wrap mb-3">
    <button class="btn btn-primary"  onclick="callApi('metrics','all')">All Metrics</button>
    <button class="btn btn-danger"   onclick="callApi('metrics','instagram')">Instagram</button>
    <button class="btn btn-info"     onclick="callApi('metrics','twitter')">Twitter</button>
    <button class="btn btn-success"  onclick="callApi('posts','all')">Posts</button>
    <button class="btn btn-secondary" onclick="callApi('webhooks','all')">Webhooks Info</button>
  </div>
  <pre id="apiOut" class="bg-dark text-success p-3 rounded" style="min-height:120px">// Response will appear here</pre>
</div></div>
<script>
function callApi(endpoint, platform) {
  document.getElementById("apiOut").textContent = "Loading...";
  fetch(`<?php echo BASE_URL; ?>index.php?controller=api&action=data&endpoint=${endpoint}&platform=${platform}`)
    .then(r => r.json())
    .then(d => { document.getElementById("apiOut").textContent = JSON.stringify(d, null, 2); })
    .catch(e => { document.getElementById("apiOut").textContent = "Error: " + e; });
}
</script>
<?php require "views/layouts/footer.php"; ?>