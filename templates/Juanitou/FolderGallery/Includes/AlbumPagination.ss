<% if $AlbumFolders.MoreThanOnePage %>
	<br class="clear" />
	<div class="pagination">
		<% if $AlbumFolders.NotFirstPage %>
			<a class="prev" href="$AlbumFolders.PrevLink"><%t Juanitou\FolderGallery\Foldergallery.PREVIOUS 'prev' %></a>
		<% end_if %>

		<% loop $AlbumFolders.Pages %>
			<% if CurrentBool %>
				$PageNum
			<% else %>
				<% if Link %>
					<a href="$Link">$PageNum</a>
				<% else %>
							...
				<% end_if %>
			<% end_if %>
		<% end_loop %>

		<% if $AlbumFolders.NotLastPage %>
			<a class="next" href="$AlbumFolders.NextLink"><%t Juanitou\FolderGallery\Foldergallery.NEXT 'next' %></a>
		<% end_if %>
	</div>
<% end_if %>
