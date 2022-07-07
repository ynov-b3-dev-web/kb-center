# References in React

## Summary

- [Controlled component](#controlled)
- [Uncontrolled component](#uncontrolled)
- [Rendering React](#rendering)
- [References](#ref)
- [Use cases](#usecase)

### Controlled Component

In HTML, form elements such as `input`, `textarea`, and `select` usually maintain their own state and update based on user input. In React, immutable state is usually stored in the state property of components and updated only with setState().
We can combine these two concepts by using the React local state as the “single source of truth”. Thus the React component that displays the form also controls its behavior with respect to user input. A form field whose state is controlled in this way by React is called a "controlled component".
Each changing state of a controlled component will re-render the component.

### Uncontrolled Component

Simply the elements managed via the DOM (like in VanillaJS). React will not re-render an uncontrolled Component.

### Rendering react

React elements are immutable. Once your element has been created, you cannot modify its children or attributes. An element is like a picture in a movie at a given moment: it represents the user interface at a specific point in time.
With our current knowledge, the only way to update the UI is to create a new element and pass it to ReactDOM.render().

### Use cases

When is it interesting to use ref and when is it not ?

#### Interesting ways

- To focus some React Component

```js
function focus() {
  inputRef.current.focus()
}
return (
  <>
    <input ref={inputRef} value={name} onChange={e => setName(e.target.value)} />
    <button onClick={focus}></button>
  </>
);
```

- When using some DOM libraries
- Useful to keep values between different renders without causing other renders,  [example here](src/App.js).
- Access to DOM elements

#### Not recommended ways

- To manage state instead of React hooks
