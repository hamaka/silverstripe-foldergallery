<% if $AlbumImages.MoreThanOnePage %>
	<br class="clear" />
	<div class="pagination">
		<% if $AlbumImages.NotFirstPage %>
			<a class="prev" href="$AlbumImages.PrevLink"><%t Foldergallery.PREVIOUS 'Prev' %></a>
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
			<a class="next" href="$AlbumImages.NextLink"><%t Foldergallery.NEXT 'Next' %></a>
		<% end_if %>
	</div>	
<% end_if %>