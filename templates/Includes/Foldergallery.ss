<div id="cwsoft-foldergallery">

<% include GalleryBreadcrumbs %>

<% if $AlbumFolders %>
	<p class="infos">
		<%t Foldergallery.DISPLAYED_ALBUMS 'Displayed albums' %>: 
		
		<% if $AlbumFolders.MoreThanOnePage %>
			{$AlbumFolders.FirstItem}-{$AlbumFolders.LastItem} / $AlbumFolders.Count
		<% else %>
			$AlbumFolders.Count / $AlbumFolders.Count
		<% end_if %>
	</p>
	
	<% loop $AlbumFolders %>
		<div class="album">
			<% if $AlbumNumberImages != 0 && $AlbumNumberSubAlbums == 0 %>
				<a href="$AlbumURL" title="<%t Foldergallery.ALBUM 'Album' %>: $Title <%t Foldergallery.NUMBER_OF_IMAGES '(Images: {images})' images=$AlbumNumberImages %>">
					<% with $AlbumCoverImage %>
						$CroppedImage($Top.ThumbnailWidth, $Top.ThumbnailHeight)
					<% end_with %>
				</a>
				
				<ul class="album-description">
					<li class="title">&raquo; $Title &laquo;</li>
					<li><%t Foldergallery.NUMBER_OF_IMAGES '(Images: {images})' images=$AlbumNumberImages %></li>
				</ul>
				
			<% else %>
				<a href="$AlbumURL" title="<%t Foldergallery.ALBUM 'Album' %>: $Title <%t Foldergallery.NUMBER_OF_SUB_ALBUMS '(Sub albums: {subAlbums})' subAlbums=$AlbumNumberSubAlbums %>">
					<img src="cwsoft-foldergallery/images/subfolder.png" class="subfolder" alt="subfolders"/>
				</a>

				<ul class="album-description">
					<li class="title">&raquo; $Title &laquo;</li>
					<li><%t Foldergallery.NUMBER_OF_SUB_ALBUMS '(Sub albums: {subAlbums})' subAlbums=$AlbumNumberSubAlbums %></li>
				</ul>
			<% end_if %>
		</div>
	<% end_loop %>

	<% include AlbumPagination %>
	
<% else  %>
	<% if $AlbumImages %>
		<p class="infos">
			<%t Foldergallery.DISPLAYED_IMAGES 'Displayed images' %>:

			<% if $AlbumImages.MoreThanOnePage %>
				{$AlbumImages.FirstItem}-{$AlbumImages.LastItem} / $AlbumImages.Count
			<% else %>
				$AlbumImages.Count / $AlbumImages.Count
			<% end_if %>
			
			<a href="#" id="cboxStartSlideShow" class="hidden"><%t Foldergallery.START_SLIDESHOW 'start slideshow' %></a>
		</p>
		
		<% loop $AlbumImages %>
			<div class="photo">
				<a href="$SetRatioSize($Top.PreviewImageMaxSize, $Top.PreviewImageMaxSize).URL" rel="album" title="$Caption">
					$CroppedImage($Top.ThumbnailWidth, $Top.ThumbnailHeight)
				</a>
			</div>
		<% end_loop %>
	
		<% include ImagePagination %>
	
	<% else %>
		<blockquote>
			<strong><%t Foldergallery.NOTE 'Note' %>:</strong>
			<%t Foldergallery.ALBUM_HAS_NO_IMAGES 'This album has no images assigned yet (try synchronizing the assets folder).' %>
		</blockquote>
	<% end_if %>
<% end_if %>
	
<% include Backlink %>
	
</div>