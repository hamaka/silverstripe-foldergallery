<%-- Note: To adapt the Foldergallery layout to your theme layout, follow the steps below: --%>
<%--   1. copy "themes/your-template/templates/Layout/Page.ss" to "cwsoft-foldergallery/templates/Layout/cwsFolderGalleryPage.ss" --%>
<%--   2. add the code "<% include Foldergallery %>" after "$Content" (in file cwsFolderGalleryPage.ss) --%>
<%--   3. flush the cache and visit the Foldergallery page in the frontend --%>

<%-- Foldergallery page layout for the SilverStripe 3.x simple theme --%>
<% include SideBar %>
<div class="content-container typography unit size3of4 lastUnit">
	<article>
		<h1>$Title</h1>
		<div class="content">
			$Content
			<% include Foldergallery %>	
		</div>
	</article>
	$Form
	$PageComments
</div>