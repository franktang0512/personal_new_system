<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>Hello React!</title>
	
	<script src="js/reactjs/react.min.js"></script>
    <script src="js/reactjs/react-dom.min.js"></script>
    <script src="js/reactjs/babel.min.js"></script>
	
	
    <!--script src="https://cdn.bootcss.com/react/15.4.2/react.min.js"></script>
    <!script src="https://cdn.bootcss.com/react/15.4.2/react-dom.min.js"></script>
    <!script src="https://cdn.bootcss.com/babel-standalone/6.22.1/babel.min.js"></script-->
  </head>
  <body>
    <div id="example"></div>
    <script type="text/babel">
		var TextAreaCounter = React.createClass({
		
			propTypes:{
				text:React.PropTypes.string
			},
			
			render:function(){
				return React.DOM.div(null,
					React.DOM.textarea({
						defaultValue: this.props.text
					}),
					React.DOM.h3(null,this.props.text.length)
				)
			}
		});
      
	  
	  	ReactDOM.render(
			React.createElement(TextAreaCounter,{
			text:"Bob"
			}),
			document.getElementById('example')
		);
	
	    // ReactDOM.render(
        // React.DOM.h1({id:"my-heading"},React.DOM.span(null,"Hell"),"o"),
        // document.getElementById('example')
      // );
	    // ReactDOM.render(
        // React.DOM.h1(null,"Hello World!"),
        // document.getElementById('example')
      // );
      // ReactDOM.render(
        // <h1>Hello, world!</h1>,
        // document.getElementById('example')
      // );
    </script>
  </body>
</html>