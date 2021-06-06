Feature: Exporting features to HTML

  Scenario: convert a simple scenario to HTML

    Given the directory "features" has a file called "example.feature" containing:
    """
    Feature: Feature title

      Scenario: Scenario title
        Given step
        When step
        Then step
    """
    When I export this directory to HTML
    Then the export directory should have a file called "example.html" containing:
    """
    <div class="feature">
      <div class="title"><span class="keyword">Feature</span>: Feature title</div>
      <div class="scenario">
        <div class="title"><span class="keyword">Scenario</span>: Scenario title</div>
        <div class="steps">
          <div class="step"><span class="keyword">Given</span> step</div>
          <div class="step"><span class="keyword">When</span> step</div>
          <div class="step"><span class="keyword">Then</span> step</div>
        </div>
      </div>
    </div>
    """

  Scenario: export the scenario background

    Given the directory "features" has a file called "background.feature" containing:
    """
    Feature:

      Background: The background
        Given step

      Scenario:
        Given step
    """
    When I export this directory to HTML
    Then the export directory should have a file called "background.html" containing:
    """
    <div class="feature">
      <div class="title"><span class="keyword">Feature</span>:</div>
      <div class="scenario background">
        <div class="title"><span class="keyword">Background</span>: The background</div>
        <div class="steps">
          <div class="step"><span class="keyword">Given</span> step</div>
        </div>
      </div>
      <div class="scenario">
    """

  Scenario: convert a table to HTML

    Given the directory "features" has a file called "table.feature" containing:
    """
    Feature: Feature title

      Scenario: Scenario title
        Given step:
          | Row 1 column 1 | Row 1 column 2 |
          | Row 2 column 1 | Row 2 column 2 |
    """
    When I export this directory to HTML
    Then the export directory should have a file called "table.html" containing:
    """
    <div class="step"><span class="keyword">Given</span> step:<div class="table-argument">
        <table>
          <tbody>
          <tr>
            <td>Row 1 column 1</td>
            <td>Row 1 column 2</td>
          </tr>
          <tr>
            <td>Row 2 column 1</td>
            <td>Row 2 column 2</td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
    """

  Scenario: convert a big string to HTML

    Given the directory "features" has a file called "pystring.feature" containing:
    """
    Feature: Feature title

      Scenario: Scenario title
        Given step:
          '''
          Large string
          '''
    """
    When I export this directory to HTML
    Then the export directory should have a file called "pystring.html" containing:
    """
    <div class="step">
      <span class="keyword">Given</span> step:<div class="pystring-argument">
        <pre>Large string</pre>
      </div>
    </div>
    """

  Scenario: convert a scenario outline with examples

    Given the directory "features" has a file called "scenario_outline.feature" containing:
    """
    Feature: Feature title

      Scenario Outline:
        Given step: <Value>

        Examples:
          | Value 1 | Value 2 |
          | 1       | 2       |
          | 3       | 4       |
    """
    When I export this directory to HTML
    Then the export directory should have a file called "scenario_outline.html" containing:
    """
    <div class="scenario outline">
      <div class="title"><span class="keyword">Scenario Outline</span>:</div>
      <div class="steps">
        <div class="step"><span class="keyword">Given</span> step: &lt;Value&gt;</div>
      </div>
      <div class="examples">
        <div class="title"><span class="keyword">Examples</span>:</div>
        <div class="example-table">
          <table>
            <tbody>
            <tr>
              <td>Value 1</td>
              <td>Value 2</td>
            </tr>
            <tr>
              <td>1</td>
              <td>2</td>
            </tr>
            <tr>
              <td>3</td>
              <td>4</td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    """

  Scenario: combine multiple features by tag in a single file
    Given the directory "features" has a file called "interesting_1.feature" containing:
    """
    @interesting
    Feature: to be included 1
      Scenario:
        Given step
    """
    And this directory has a file called "interesting_2.feature" containing:
    """
    @interesting
    Feature: to be included 2
      Scenario:
        Given step
    """
    And this directory has a file called "irrelevant.feature" containing:
    """
    @irrelevant
    Feature: irrelevant
      Scenario:
        Given step
    """
    When I export this directory to HTML providing the tag "interesting"
    Then the export directory should have a file called "interesting.html" containing:
    """
    to be included 1
    """
    And this file should also contain:
    """
    to be included 2
    """
    And the file "interesting.html" should not contain "irrelevant"




  Scenario: combine multiple features by tag in a single file with specified name
    Given the directory "features" has a file called "interesting_1.feature" containing:
    """
    @interesting
    Feature: to be included 1
      Scenario:
        Given step
    """
    And this directory has a file called "interesting_2.feature" containing:
    """
    @interesting
    Feature: to be included 2
      Scenario:
        Given step
    """
    And this directory has a file called "irrelevant.feature" containing:
    """
    @irrelevant
    Feature: irrelevant
      Scenario:
        Given step
    """
    When I export this directory to HTML providing the tag "interesting" and merge to "index"
    Then the export directory should have a file called "index.html" containing:
    """
    to be included 1
    """
    And this file should also contain:
    """
    to be included 2
    """
    And the file "index.html" should not contain "irrelevant"



  Scenario: generate a table of contents

    Given the directory "features" has a file called "interesting_1.feature" containing:
    """
    @interesting
    Feature: to be included 1
      Scenario:
        Given step
    """
    And this directory has a file called "interesting_2.feature" containing:
    """
    @interesting
    Feature: to be included 2
      Scenario:
        Given step
    """
    When I export this directory to HTML providing the tag "interesting"
    Then the export directory should have a file called "interesting.html" containing:
    """
    <div class="table-of-contents">
      <div class="title">Table of contents</div>
      <ul>
        <li>
          <a href="#d20dbc93b3f8be5f9c91b02de0b38a27">To be included 1</a>
        </li>
        <li>
          <a href="#3b2192aa16c02b0fe12de7b002f80eef">To be included 2</a>
        </li>
      </ul>
    </div>
    """
    And this file should also contain:
    """
    <a id="d20dbc93b3f8be5f9c91b02de0b38a27"></a>
    <div class="feature">
      <div class="title"><span class="keyword">Feature</span>: to be included 1</div>
    """
    And this file should also contain:
    """
    <a id="3b2192aa16c02b0fe12de7b002f80eef"></a>
    <div class="feature">
      <div class="title"><span class="keyword">Feature</span>: to be included 2</div>
    """

  Scenario: wrap everything in a layout, add a title, and include the CSS

    Given the directory "features" has a file called "interesting.feature" containing:
    """
    @interesting
    Feature: to be included
      Scenario:
        Given step
    """
    When I export this directory to HTML providing the tag "interesting" and the stylesheet "style.css"
    Then the export directory should have a file called "interesting.html" containing:
    """
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>interesting features</title>
      <link rel="stylesheet" href="style.css">
    </head>
    <body>
    """
    And this file should also contain:
    """
    </body>
    </html>
    """

  Scenario: the feature description will be parsed as Markdown

    Given the directory "features" has a file called "feature_description.feature" containing:
      """
      Feature:

        Multi-line
        paragraph 1

        Paragraph 2
      """
    When I export this directory to HTML
    Then the export directory should have a file called "feature_description.html" containing:
    """
    <div class="description">
      <p>Multi-line
  paragraph 1</p>
      <p>Paragraph 2</p>
    </div>
    """

  Scenario: the scenario description will be parsed as Markdown

    Given the directory "features" has a file called "scenario_description.feature" containing:
      """
      Feature:

        Scenario: Scenario title

          Multi-line
          paragraph 1

          Paragraph 2
      """
    When I export this directory to HTML
    Then the export directory should have a file called "scenario_description.html" containing:
    """
    <div class="description">
      <p>Multi-line
  paragraph 1</p>
      <p>Paragraph 2</p>
    </div>
    """

  Scenario: the background description will be parsed as Markdown

    Given the directory "features" has a file called "background_description.feature" containing:
      """
      Feature:

        Background: Background title

          Multi-line
          paragraph 1

          Paragraph 2
      """
    When I export this directory to HTML
    Then the export directory should have a file called "background_description.html" containing:
    """
    <div class="description">
      <p>Multi-line
  paragraph 1</p>
      <p>Paragraph 2</p>
    </div>
    """
