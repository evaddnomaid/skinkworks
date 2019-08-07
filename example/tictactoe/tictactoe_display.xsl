<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet
    version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
>
<xsl:output method="html"/>

<xsl:variable name="winner">
    <xsl:call-template name="give_winner"/>
</xsl:variable>

<xsl:variable name="next_player">
    <xsl:call-template name="give_next_player"/>
</xsl:variable>

<xsl:template match="/">
    <html>
        <head><title>tictactoe</title></head>
        <body>
            <h1>Tic Tac Toe</h1>
            <h2>Board state</h2>
            <xsl:apply-templates/>
            <xsl:choose>
                <xsl:when test="$winner = 'none'">
                    <xsl:call-template name="show_form"/>
                </xsl:when>
                <xsl:otherwise>
                    <h2>Winner</h2>
                    <p><xsl:value-of select="$winner"/></p>
                </xsl:otherwise>
            </xsl:choose>
        </body>
    </html>
</xsl:template>

<xsl:template name="show_form">
    <h2>Next Play</h2>
    <p>Next player is: <xsl:value-of select="$next_player"/></p>
    <form action="placeholder.php">
    <p>
    Square to place the <b><xsl:value-of select="$next_player"/></b>: <input type="text" size="2" name="position"/>
    <xsl:element name="input">
        <xsl:attribute name="name">player</xsl:attribute>
        <xsl:attribute name="value">
            <xsl:value-of select="$next_player"/>
        </xsl:attribute>
        <xsl:attribute name="type">hidden</xsl:attribute>
    </xsl:element>
    <input type="submit" value="Submit"/>
    </p>
    </form>
</xsl:template>

<xsl:template match="board">
    <table border="1">
        <tr><th/><th>1</th><th>2</th><th>3</th></tr>
        <xsl:apply-templates/>
    </table>
</xsl:template>

<xsl:template match="row">
<tr><th><xsl:value-of select="substring(cell[1]/@id, 1, 1)"/></th><xsl:apply-templates/></tr>
</xsl:template>

<xsl:template match="cell">
<td><xsl:value-of select="."/></td>
</xsl:template>

<xsl:template match="grub"/>

<xsl:template match="*">
    <xsl:apply-templates/>
</xsl:template>

<xsl:template name="give_next_player">
    <xsl:choose>
        <xsl:when test="$winner = 'cat'">game over</xsl:when>
        <xsl:when test="count(//cell[. = 'O']) &gt; count(//cell[. = 'X'])">X</xsl:when>
        <xsl:otherwise>O</xsl:otherwise>
    </xsl:choose>
</xsl:template>

<xsl:template name="give_winner">
    <xsl:choose>
        <!-- Columns -->
        <xsl:when test="//cell[@id='A1'] = //cell[@id='A2'] and //cell[@id='A2'] = //cell[@id='A3'] and //cell[@id='A1'] != ''">
            <xsl:value-of select="//cell[@id='A1']"/>
        </xsl:when>
        <xsl:when test="//cell[@id='B1'] = //cell[@id='B2'] and //cell[@id='B2'] = //cell[@id='B3'] and //cell[@id='B1'] != ''">
            <xsl:value-of select="//cell[@id='B1']"/>
        </xsl:when>
        <xsl:when test="//cell[@id='C1'] = //cell[@id='C2'] and //cell[@id='C2'] = //cell[@id='C3'] and //cell[@id='C1'] != ''">
            <xsl:value-of select="//cell[@id='C1']"/>
        </xsl:when>
        <!-- Rows -->
        <xsl:when test="//cell[@id='A1'] = //cell[@id='B1'] and //cell[@id='B1'] = //cell[@id='C1'] and //cell[@id='A1'] != ''">
            <xsl:value-of select="//cell[@id='A1']"/>
        </xsl:when>
        <xsl:when test="//cell[@id='A2'] = //cell[@id='B2'] and //cell[@id='B2'] = //cell[@id='C2'] and //cell[@id='A2'] != ''">
            <xsl:value-of select="//cell[@id='A2']"/>
        </xsl:when>
        <xsl:when test="//cell[@id='A3'] = //cell[@id='B3'] and //cell[@id='B3'] = //cell[@id='C3'] and //cell[@id='A3'] != ''">
            <xsl:value-of select="//cell[@id='A3']"/>
        </xsl:when>
        <!-- Diagonal -->
        <xsl:when test="//cell[@id='A1'] = //cell[@id='B2'] and //cell[@id='B2'] = //cell[@id='C3'] and //cell[@id='A1'] != ''">
            <xsl:value-of select="//cell[@id='A1']"/>
        </xsl:when>
        <xsl:when test="//cell[@id='A3'] = //cell[@id='B2'] and //cell[@id='B2'] = //cell[@id='C1'] and //cell[@id='A3'] != ''">
            <xsl:value-of select="//cell[@id='A3']"/>
        </xsl:when>
        <xsl:when test="//cell = ''">none</xsl:when>
        <xsl:otherwise>cat</xsl:otherwise>
    </xsl:choose>
</xsl:template>

</xsl:stylesheet>
