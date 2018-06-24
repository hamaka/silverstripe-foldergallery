<% if $AlbumImages.MoreThanOnePage %>
	<br class="clear" />
	<div class="pagination">
		<% if $AlbumImages.NotFirstPage %>
			<a class="prev" href="$AlbumImages.PrevLink"><%t Juanitou\FolderGallery\Foldergallery.PREVIOUS 'prev' %></a>
		<% end_if %>

		<% loop $AlbumImages.Pages %>
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

		<% if $AlbumImages.NotLastPage %>
			<a class="next" href="$AlbumImages.NextLink"><%t Juanitou\FolderGallery\Foldergallery.NEXT 'next' %></a>
		<% end_if %>
	</div>
<% end_if %>
