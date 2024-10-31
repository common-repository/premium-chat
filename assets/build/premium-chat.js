
const {registerBlockType} = wp.blocks; //Blocks API
const {createElement} = wp.element; //React.createElement
const {__} = wp.i18n; //translation functions

// This will create a custom icon
const premiumChatIcon = createElement('svg',{ 
                          width: 20, 
                          height: 20 
                        },
                        createElement( 'path',
                          { 
                            d: "M10 0.4c-5.302 0-9.6 4.298-9.6 9.6s4.298 9.6 9.6 9.6c5.301 0 9.6-4.298 9.6-9.601 0-5.301-4.299-9.599-9.6-9.599zM10 17.599c-4.197 0-7.6-3.402-7.6-7.6s3.402-7.599 7.6-7.599c4.197 0 7.601 3.402 7.601 7.6s-3.404 7.599-7.601 7.599zM7.501 9.75c0.828 0 1.499-0.783 1.499-1.75s-0.672-1.75-1.5-1.75-1.5 0.783-1.5 1.75 0.672 1.75 1.501 1.75zM12.5 9.75c0.829 0 1.5-0.783 1.5-1.75s-0.672-1.75-1.5-1.75-1.5 0.784-1.5 1.75 0.672 1.75 1.5 1.75zM14.341 11.336c-0.363-0.186-0.815-0.043-1.008 0.32-0.034 0.066-0.869 1.593-3.332 1.593-2.451 0-3.291-1.513-3.333-1.592-0.188-0.365-0.632-0.514-1.004-0.329-0.37 0.186-0.52 0.636-0.335 1.007 0.050 0.099 1.248 2.414 4.672 2.414 3.425 0 4.621-2.316 4.67-2.415 0.184-0.367 0.036-0.81-0.33-0.998z" 
                          }
                        ));

/* This section of the code registers a new block, sets an icon and a category, and indicates what type of fields it'll include. */
registerBlockType('premium-chat/premium-chat', {
    title: 'Premium.Chat',
    icon: {
        // Specifying a background color to appear with the icon e.g.: in the inserter.
        background: '#4FC77F',
        // Specifying a color for the icon (optional: if not set, a readable color will be automatically defined)
        foreground: '#fff',
        // Specifying a dashicon for the block
        src: 'format-chat',
    },
    category: 'premium-chat-blocks',
    attributes: {
      id: {type: 'string', default: 1}
    },
    edit(props){

      const attributes    =  props.attributes;
      const setAttributes =  props.setAttributes;
      
      //Function to update id attribute
      function updateId(event) {
        props.setAttributes({id: event.target.value})
      }

      //Display block preview and UI
      return createElement('div', {}, [
          createElement(
            "h3",
            null,
            __("Premium.Chat Widget","premium-chat")
          ),
          createElement(
            "p",
            null,
            __("Add your widget ID in the below input field.","premium-chat")
          ),
          createElement("input",{ 
              type: "number", 
              value: props.attributes.id, 
              onChange: updateId
          }),
      ] )
      
    },
    save(){
      return null;//save has to exist. This all we need
    }
    
})