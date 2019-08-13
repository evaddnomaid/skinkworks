test: example/tictactoe/tictactoe_egg.dtd example/tictactoe/tictactoe_egg.xml
	xmllint --dtdvalid example/tictactoe/tictactoe_egg.dtd example/tictactoe/tictactoe_egg.xml >/dev/null
