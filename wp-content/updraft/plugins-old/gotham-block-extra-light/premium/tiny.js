(function() {

	function set_shortcodes_atts( editor, atts ) {

		// nom fenetre
		var titreFenetre = !_.isUndefined( atts.nom ) ? atts.nom : 'Ajouter un shortcode';
		// balise du shortcode
		var balise = !_.isUndefined( atts.balise ) ? atts.balise : false;

		fn = function() {
			editor.windowManager.open( {
				title: titreFenetre,
				body: atts.body,
				onsubmit: function( e ) {
					var out = '[' + balise;
					for ( var attr in e.data ) {
						out += ' ' + attr + '="' + e.data[ attr ] + '"';
					}
					out += ']';
					editor.insertContent( out );
				},
			} );
		};
		return fn;
	}

	tinymce.PluginManager.add('ekoghostban', function( editor, url ) {

		editor.addButton('gtadb_premium_bouton', {
			icon: true,
			image: ' data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAAvQAAAL0BHVrG+gAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAFgSURBVEiJ7dWvTh1BFMfxzwEKCHgBoAYPEhJEBU3TUA0JSR+AVKFRvAEJjgfAVGGw1HNdCRWkFiwIzG1DMpjZ3LnL7r38Ve1JjtjzO/P7zs6czUZKSVtERGAVS0VCp8gfaZBJSqkxMYcTpCF5grlWnxbzDVw/wrzKa2w8CoD1JxjXc30gANO4fAHgElODAHsvMK9yrxGAedy9AuAO85XvSDFQKxitT9kzYjR7QR9g4RXMq1hsAiw2ND43epst7uBK7xwvcIwbw8/8JvdeFLWrpkvuFg2dXIu8m284KvSjXFtA5N5OoXeHAW4xUxvhg0I/qGkzec0DwFjLGU7hZ0Rs4y+WsVXoWxFxi1OMYz+veRDV64mILiZagE+NPymlSfqn6E3iP+AfBrT/xNu1xnodcI6vmMVhTfuNT/iAXzXtO95jE2f92N7n/kX+8Irax7xgFxNF/R128oY+19YE1qrnezsEkbKCMN3OAAAAAElFTkSuQmCC',
			text:'Unblock Ads',
			type:'menubutton',
			menu: [
							
				{
					text: 'AntiAdblock 4 Banners',
					onclick: set_shortcodes_atts( editor, {
						body: [
							{
								label: 'Url',
								name: 'url',
								type: 'textbox',
								tooltip: 'Type url href :',
								value: '',
							},
							{
								label: 'Image URL',
								name: 'image_url',
								type: 'textbox',
								tooltip: 'Type image URL src :',
								value: '',
							},
							{
								label: 'Image Alt',
								name: 'alt',
								type: 'textbox',
								tooltip: 'Type image ALT :',
								value: '',
							},
							{
								label: 'Image Width',
								name: 'width',
								type: 'textbox',
								tooltip: 'Type image width :',
								value: '',
							},
							{
								label: 'Image Height',
								name: 'height',
								type: 'textbox',
								tooltip: 'Type image height :',
								value: '',
							},
							{
								label: 'Target',
								name: 'target',
								type: 'listbox',
								values : [
									{ text: '_Blank', value: 'blank' },
			                        { text: '_Self', value: 'self' },
			                    ]
							},
							{
								label: 'Cloaking',
								name: 'cloaking',
								type: 'listbox',
								values : [
									{ text: 'Yes', value: 'yes' },
			                        { text: 'No', value: 'no' },
			                    ]
							},
						],
						balise: 'ghostban',
						nom: 'AntiAdblock 4 Banners',
					} ),
				},
			]
		});
	});

})();