<div id="foldergallery">

<% include Juanitou\FolderGallery\GalleryBreadcrumbs %>

<% if $AlbumFolders %>
	<p class="infos">
		<%t Juanitou\FolderGallery\Foldergallery.DISPLAYED_ALBUMS 'Displayed albums' %>:

		<% if $AlbumFolders.MoreThanOnePage %>
			{$AlbumFolders.FirstItem}-{$AlbumFolders.LastItem} / $AlbumFolders.Count
		<% else %>
			$AlbumFolders.Count / $AlbumFolders.Count
		<% end_if %>
	</p>

	<% loop $AlbumFolders %>
		<div class="album">
			<% if $AlbumNumberImages != 0 && $AlbumNumberSubAlbums == 0 %>
				<a href="$AlbumURL" title="<%t Juanitou\FolderGallery\Foldergallery.ALBUM 'Album' %>: $Title <%t Juanitou\FolderGallery\Foldergallery.NUMBER_OF_IMAGES '(Images: {images})' images=$AlbumNumberImages %>">
					<% with $AlbumCoverImage %>
            $Fill($Top.ThumbnailWidth, $Top.ThumbnailHeight)
					<% end_with %>
				</a>

				<ul class="album-description">
					<li class="title">&raquo; $Title &laquo;</li>
					<li><%t Juanitou\FolderGallery\Foldergallery.NUMBER_OF_IMAGES '(Images: {images})' images=$AlbumNumberImages %></li>
				</ul>

			<% else %>
				<a href="$AlbumURL" title="<%t Juanitou\FolderGallery\Foldergallery.ALBUM 'Album' %>: $Title <%t Juanitou\FolderGallery\Foldergallery.NUMBER_OF_SUB_ALBUMS '(Sub albums: {subAlbums})' subAlbums=$AlbumNumberSubAlbums %>">
					<img src="foldergallery/images/subfolder.png" class="subfolder" alt="subfolders"/>
				</a>

				<ul class="album-description">
					<li class="title">&raquo; $Title &laquo;</li>
					<li><%t Juanitou\FolderGallery\Foldergallery.NUMBER_OF_SUB_ALBUMS '(Sub albums: {subAlbums})' subAlbums=$AlbumNumberSubAlbums %></li>
				</ul>
			<% end_if %>
		</div>
	<% end_loop %>

	<% include Juanitou\FolderGallery\AlbumPagination %>

<% else  %>
	<% if $AlbumImages %>
		<p class="infos">
			<%t Juanitou\FolderGallery\Foldergallery.DISPLAYED_IMAGES 'Displayed images' %>:

			<% if $AlbumImages.MoreThanOnePage %>
				{$AlbumImages.FirstItem}-{$AlbumImages.LastItem} / $AlbumImages.Count
			<% else %>
				$AlbumImages.Count / $AlbumImages.Count
			<% end_if %>

			<a href="#" id="cboxStartSlideShow" class="hidden"><%t Juanitou\FolderGallery\Foldergallery.START_SLIDESHOW 'start slideshow' %></a>
		</p>

		<% loop $AlbumImages %>
			<div class="photo">
				<a href="$Fit($Top.PreviewImageMaxSize, $Top.PreviewImageMaxSize).URL" rel="album" title="$Caption">
					$Fill($Top.ThumbnailWidth, $Top.ThumbnailHeight)
				</a>
			</div>
		<% end_loop %>

		<% include Juanitou\FolderGallery\ImagePagination %>

	<% else %>
		<blockquote>
			<strong><%t Juanitou\FolderGallery\Foldergallery.NOTE 'Note' %>:</strong>
			<%t Juanitou\FolderGallery\Foldergallery.ALBUM_HAS_NO_IMAGES 'This album has no images assigned yet.' %>
		</blockquote>
	<% end_if %>
<% end_if %>

<% include Juanitou\FolderGallery\Backlink %>

</div>
